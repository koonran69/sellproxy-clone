<?php

namespace App\Models;

use App\Core\Enums\GetProxy\ProxyProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProxyConnectionLog extends Model
{
    use HasFactory;

    // Lưu ý: Đảm bảo tên bảng khớp với file Migration bạn đã chạy
    protected $table = 'proxy_connection_logs';

    protected $fillable = [
        'username',
        'email',
        'password',
        'provider',
        'is_success',
        'request_data',
        'response_data',
        'ip_address',
    ];

    /**
     * Tự động cast dữ liệu JSON về Array khi truy vấn
     */
    protected $casts = [
        'provider' => ProxyProvider::class,
        'request_data' => 'array',
        'response_data' => 'array',
        'is_success' => 'boolean',
    ];

    /**
     * Khởi tạo bộ giải mã riêng biệt với Key cố định từ .env
     */
    protected function getCustomEncrypter()
    {
        $key = env('PROXY_LOG_ENCRYPTION_KEY','abc');
        // Đảm bảo key đủ độ dài cho AES-256-CBC (32 ký tự)
        return new Encrypter((string) $key, 'AES-256-CBC');
    }

    /**
     * Mutator: Mã hóa password trước khi lưu
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = $this->getCustomEncrypter()->encrypt($value, false);
        }
    }

    /**
     * Accessor: Giải mã password khi truy vấn
     */
    public function getPasswordAttribute($value)
    {
        try {
            return $value ? $this->getCustomEncrypter()->decrypt($value, false) : null;
        } catch (\Exception $e) {
            return "******** (Lỗi giải mã/Sai Key)";
        }
    }
    /**
     * Hàm hỗ trợ lưu log nhanh
     * * @param array $data Dữ liệu từ request
     * @param array $result Kết quả từ service
     * @param string $provider Tên nhà cung cấp
     * @param Request $request Object request để lấy IP
     */
    public static function storeLog(array $data, array $result, string $provider, Request $request)
    {
        return self::create([
            'username'      => $data['username'] ?? null,
            'email'         => $data['email'] ?? null,
            'password'      => $data['password'] ?? null, // Tự động kích hoạt setPasswordAttribute
            'provider'      => $provider,
            'is_success'    => (bool) ($result['success'] ?? false),
            'request_data'  => $data,
            'response_data' => $result,
            'ip_address' => $request->header('X-Forwarded-For') ?? $request->ip(),
        ]);
    }
}
