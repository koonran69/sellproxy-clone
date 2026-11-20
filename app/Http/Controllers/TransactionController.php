<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Models\VietqrBank;
use App\Services\VietQRService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class TransactionController extends Controller
{
    private $vietQRService;

    public function __construct(VietQRService $vietQRService) {
        $this->vietQRService = $vietQRService;
    }

    public function show(Request $request, $code)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $transaction = $user->transactions()->with('reference')->where('code', $code)->first();
        if(!$transaction) {
            abort(404);
        }

        $setting = Setting::getAll();

        $bank_account_id = $setting->get('bank_account_id');
        $bank = VietqrBank::where("bin", $bank_account_id)->first();
        $paymentInfo = [
            'bank_account_no' => $setting->get('bank_account_no'),
            'bank_account_name' => $setting->get('bank_account_name'),
            'bank_account_id' => $bank_account_id,
            'bank_name' => $bank->name,
            'amount' => $transaction->amount,
            'desc' => $transaction->code
        ];

        $keyCache = "vietQR_{$transaction->code}";
        $rs = Cache::get($keyCache);

        if(!$rs) {
            $service = app(\App\Services\VietQRService::class);
            $token = $service->generateToken();
            $rs = $service->generateQrCodeWithTransactionSync($token['access_token'], $transaction->amount, $code);
            $expiresAt = now()->addSeconds(900);
            Cache::put($keyCache, $rs, $expiresAt);
            Cache::put($keyCache . '_expires_at', $expiresAt, $expiresAt);
        }

        $expiresAt = Cache::get($keyCache . '_expires_at');
        if ($expiresAt) {
            $ttl = now()->diffInSeconds($expiresAt, false);
        } else {
            $ttl = 0;
        }
        $data['qrCode'] = $rs;
        $data['remaining_seconds'] = floor($ttl);
        $data['payment_info'] = $paymentInfo;
        $data['transaction'] = $transaction;
        return view("public.payment.vietQR")->with($data);
    }

    public function checkStatusPaymentTransaction(Request $request) {
        $user = Auth::user();
        $code = $request->code;
        $transaction = $user->transactions()->where('code', $code)->first();
        return [
            'success' => true,
            'status' => $transaction->status
        ];
    }
}
