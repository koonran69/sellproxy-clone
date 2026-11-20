<?php

namespace App\Http\Controllers;


use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Http\Requests\Request;
use App\Models\Transaction;
use App\Services\TokenService;
use App\Services\TransactionProcessorService;
use App\Services\VietQRService;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VietQrController extends Controller
{
    protected $vietQRService;
    protected TransactionProcessorService $transactionProcessorService;

    public function __construct(VietQRService $vietQRService, TransactionProcessorService $transactionProcessorService)
    {
        $this->vietQRService = $vietQRService;
        $this->transactionProcessorService  = $transactionProcessorService;
    }

    public function tokenGenerate(Request $request)
    {
        $api = app(TokenService::class);
        return $api->generateToken();
    }

    public function transactionSync(Request $request) {
        $authHeader = $request->header('Authorization');
        $bearerPrefix = 'Bearer ';
        if (empty($authHeader) || !str_starts_with($authHeader, $bearerPrefix)) {
            return response()->json([
                'error' => true,
                'errorReason' => 'INVALID_AUTH_HEADER',
                'toastMessage' => 'Authorization header is missing or invalid',
                'object' => null
            ], 401);
        }

        $token = substr($authHeader, strlen($bearerPrefix));

        $SECRET_KEY = config('payment.token_auth_basic.secret_key');

        if (!$this->validateToken($token, $SECRET_KEY)) {
            return response()->json([
                'error' => true,
                'errorReason' => 'INVALID_TOKEN',
                'toastMessage' => 'Invalid or expired token',
                'object' => null
            ], 401);
        }

        $data = $request->all();

        try {

            $refTransactionId = $request->orderId;

            Log::info('giao dich thanh cong', $data);

            $transactionId = $request->orderId;

            if($transactionId) {
                $this->transactionProcessorService->handle($transactionId);
            }

            return response()->json([
                'error' => false,
                'errorReason' => null,
                'toastMessage' => 'Transaction processed successfully',
                'object' => [ "reftransactionid" => $refTransactionId ]
            ], 200);

        } catch (\Exception $e) {
            Log::info('giao dich excpetion', [$e->getMessage()]);
            return response()->json([
                'error' => true,
                'errorReason' => 'TRANSACTION_FAILED',
                'toastMessage' => $e->getMessage(),
                'object' => null
            ], 400);
        }
    }

    public function validateToken($token, $secretKey) {
        try {
            JWT::decode($token, new Key($secretKey, 'HS512'));
            return true;
        } catch (ExpiredException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

}

