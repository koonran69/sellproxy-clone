<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Proxy đã mua</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            padding: 20px;
            color: #333;
        }
        .email-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        h2 {
            color: #6a22f3;
        }
        ul {
            padding-left: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }
        .order-link {
            margin-top: 20px;
            display: block;
            text-decoration: none;
            background-color: #6a22f3;
            color: white!important;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            width: fit-content;
        }
    </style>
</head>
<body>
<div class="email-container">
    <h2>Xin chào {{ $user->name }},</h2>
    <p>Bạn đã mua thành công <strong>{{ count($proxies) }}</strong> proxy. Thông tin chi tiết như sau:</p>
    
    <ul>
        @foreach ($proxies as $proxy)
            <li>{{ $proxy->ip }}:{{ $proxy->port_http }}:{{ $proxy->username }}:{{ $proxy->password }}</li>
        @endforeach
    </ul>
    
    <a href="{{ $orderUrl }}" class="order-link">Xem chi tiết đơn hàng tại đây</a>
    
    <p>Nếu bạn có bất kỳ câu hỏi nào, xin vui lòng liên hệ với đội ngũ hỗ trợ của chúng tôi.</p>
    
    <div class="footer">
        &copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
    </div>
</div>
</body>
</html>
