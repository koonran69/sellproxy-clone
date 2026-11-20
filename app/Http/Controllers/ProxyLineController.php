<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\Transaction\ReferenceType;
use App\Jobs\SendProxyJob;
use App\Models\IpVersion;
use App\Models\ProxyCategory;
use App\Models\ProxyCountry;
use App\Models\ProxyInstance;
use App\Models\ProxyLineType;
use App\Models\ProxyOrder;
use App\Models\ProxyPackage;
use App\Services\ProxyLineService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProxyLineController extends Controller
{

    public function __construct(protected ProxyLineService $proxyLineService) {

    }

    public function newOrder(Request $request)
    {
        $data = [];

        $user = auth()->user();
        if($user) {
            $data['available_balance'] = $user->available_balance ?? 0;
        }

        $availabilities = \App\Models\ProxyCountryAvailability::all();
        $grouped = $availabilities->groupBy(function ($item) {
            return $item->proxy_type_id . '_' . $item->ip_version_id;
        })->map(function ($group) {
            return $group->pluck('country_id')->unique()->values();
        });
        $data['countryAvailability'] = $grouped;
        $data['proxyCountries'] = ProxyCountry::all();
        return view("public.proxyline.newOrder")->with($data);
    }

    public function orderAmount(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'ip_version' => 'required|exists:ip_versions,id',
            'ip_type' => 'required|exists:proxy_line_types,id',
            'country' => 'required|exists:proxy_countries,id',
            'period' => 'required|integer|min:1',
        ]);

        $quantity = (int) $validated['quantity'];
        $period = (int) $validated['period'];

        $tier = $this->proxyLineService->orderAmount($validated['ip_type'], $validated['ip_version'], $quantity, $validated['country'], $period);

        if (!$tier) {
            return response()->json([
                'success' => false,
                'amount' => 0,
                'price_per_ip' => 0,
                'tier_id' => 0,
                'matched_duration' => 0,
            ]);
        }

        $amount = $quantity * $tier->price_per_ip;

        return response()->json([
            'success' => true,
            'amount' => number_format($amount),
            'price_per_ip' => number_format($tier->price_per_ip),
            'tier_id' => $tier->id,
            'matched_duration' => $tier->duration_days,
        ]);
    }

    public function payProxyLine(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để đặt hàng'], 401);
        }

        $user = Auth::user();

        $typeObj = ProxyLineType::find($request->ip_type);
        $ipVersionObj = IpVersion::find($request->ip_version);
        $type = $typeObj->slug == "shared" ? "shared" : "dedicated";
        $ip_version = $ipVersionObj->id == 1 ? 4 : 6;
        $country = ProxyCountry::find($request->country);
        $quantity = $request->quantity;
        if($request->ip_list && is_array($request->ip_list)) {
            $quantity = count($request->ip_list);
        }
        $period = $request->period;

        $tier = $this->proxyLineService->orderAmount($request->ip_type, $request->ip_version, $quantity, $request->country, $period);
        $amount = $quantity * $tier->price_per_ip;

        DB::beginTransaction();

        try {

            $proxyOrder = ProxyOrder::create([
                'user_id' => $user->id,
                'country_id' => $request->country,
                'ip_version_id' => $request->ip_version,
                'type_id' => $request->ip_type,
                'quantity' => $quantity,
                'period_days' => $period,
                'total_amount' => $amount,
            ]);

            if(!$user->checkBalanceAvailable($amount)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư ví không đủ, vui lòng nạp thêm !',
                ]);
            }

            $user->update([
                'available_balance' => DB::raw("available_balance - $amount")
            ]);

            $rs = $user->recharge($amount * -1, ReferenceType::OrderProxy, $proxyOrder->id, 'Thanh toán ví đơn hàng proxyline ' . $proxyOrder->id);

            $payload = [
                'type' => $type,
                'ip_version' => $ip_version,
                'country' => strtolower($country->code),
                'quantity' => $quantity,
                'period' => $period,
                'tags' => $request->tags
            ];

            $response = $this->proxyLineService->placeOrderToProxyline($payload);
            if (!empty($response[0]['order_id'])) {
                $proxyOrder->external_order_id = $response[0]['order_id'];
                $proxyOrder->save();
            }

            $this->proxyLineService->storeProxiesFromResponse($response, $proxyOrder->id);

            $proxyOrder = ProxyOrder::find($proxyOrder->id);
            $proxyInstanceFirst = $proxyOrder->proxyInstances[0];
            ProxyOrder::where('id', $proxyOrder->id)->update([ 'date_start' => $proxyInstanceFirst['date_start'], 'date_end' =>  $proxyInstanceFirst['date_end'] ]);

            DB::commit();

            SendProxyJob::dispatch($proxyOrder->id);

            return response()->json([
                'success' => true,
                'message' => 'Mua hàng thành công !',
                'order'   => $proxyOrder
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            // throw $exception;
            Log::info('error payProxyLine', [ $exception->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ]);
        }
    }

    public function renewOrder(Request $request)
    {
        $proxyIds = $request->query('proxies');
        $proxies = ProxyInstance::whereIn('id', $proxyIds)->get();
        $data = [];

        $user = auth()->user();
        if($user) {
            $data['available_balance'] = $user->available_balance ?? 0;
        }

        $data['proxies'] = $proxies;
        $data['order'] = $proxies[0]->order;
        $data['proxy_ids'] = implode(",", $proxyIds);
        return view("public.proxyline.renewOrder")->with($data);
    }

    public function getAmountRenew(Request $request)
    {
        $period = $request->period;
        $ids = explode(",", $request->ids);
        $totalAmount = 0;
        foreach ($ids as $proxy_id) {
            $proxyInstance = ProxyInstance::find($proxy_id);
            $order = $proxyInstance->order;
            $tier = $this->proxyLineService->orderAmount($order->type_id, $order->ip_version_id, 1, $order->country_id, $period);
            $price_per_proxy = $tier->price_per_ip;
            $totalAmount += $price_per_proxy;
        }

        return response()->json([
            'success' => true,
            'amount' => $totalAmount,
        ]);
    }

    public function payReNewProxyLine(Request $request)
    {
        $user = Auth::user();
        $period = $request->period;
        $ids = explode(",", trim($request->proxy_ids));
        $totalAmount = 0;
        $arrProxyLineId = [];
        try {
            foreach ($ids as $proxy_id) {
                $proxyInstance = ProxyInstance::find($proxy_id);
                $arrProxyLineId[] = $proxyInstance->proxyline_id;
                $order = $proxyInstance->order;
                $tier = $this->proxyLineService->orderAmount($order->type_id, $order->ip_version_id, 1, $order->country_id, $period);
                $price_per_proxy = $tier->price_per_ip;
                $totalAmount += $price_per_proxy;
            }
        } catch (\Exception $exception) {
            \Log::info('exception payReNewProxyLine', [ $exception->getMessage() ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ]);
        }

        DB::beginTransaction();
        try {

            if(!$user->checkBalanceAvailable($totalAmount)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư ví không đủ, vui lòng nạp thêm !',
                ]);
            }

            $user->update([
                'available_balance' => DB::raw("available_balance - $totalAmount")
            ]);

            $rs = $user->recharge($totalAmount * -1, ReferenceType::OrderProxy, 0, 'Renew proxies');

            $payload = [
                'period' => $period,
                'proxies' => $arrProxyLineId,
            ];

            $response = $this->proxyLineService->reNewOrder($payload);
            \Log::info('response renew ', $response);
            if (!empty($response[0]['order_id'])) {
                foreach ($response as $proxyResponse)
                {
                    $date_end = Carbon::parse($proxyResponse['date_end'])->format('Y-m-d H:i:s');
                    ProxyInstance::where('proxyline_id', $proxyResponse['id'])->update(['date_end' => $date_end]);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::info('exception payReNewProxyLine', [ $exception->getMessage() ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mua hàng thành công !',
        ]);
    }

    public function ipList(Request $request)
    {
        $ip_version = $request->ip_version == 1 ? 4 : 6;
        $country = ProxyCountry::find($request->country);
        $payload = [
            'type' => $request->ip_type,
            'ip_version' => $ip_version,
            'country' =>  strtolower($country->code)
        ];
        $response = $this->proxyLineService->ipList($payload);
        return $response;
    }

    public function tags(Request $request) {
        $response = $this->proxyLineService->tags();
        return $response;
    }
}
