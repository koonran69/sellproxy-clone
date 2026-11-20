<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin đơn hàng & CDKey</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        h1 {
            color: #333;
        }
        .proxy-block {
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            margin-top: 25px;
            padding: 20px;
            background: #fafafa;
        }
        .proxy-block h3 {
            margin-top: 0;
            color: #222;
        }
        ul {
            padding-left: 20px;
        }
        li {
            font-family: monospace;
            background: #f1f1f1;
            margin-bottom: 5px;
            padding: 6px;
            border-radius: 4px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Xin chào {{ $user?->name ?? 'Khách hàng' }},</h1>

    <p>Cảm ơn bạn đã đặt mua proxy tại <strong>{{ env('APP_NAME') }}</strong>! Dưới đây là thông tin đơn hàng và mã CDKey tương ứng:</p>

    @foreach ($items as $index => $item)
        <div class="proxy-block">
            <p><strong>Tên proxy:</strong> {{ $item['proxy_name'] }}</p>
            <p><strong>Kế hoạch:</strong> {{ $item['variant_name'] }}</p>
            <p><strong>Số lượng:</strong> {{ $item['quantity'] }}</p>

            <p><strong>🔑 Danh sách CDKey:</strong></p>
            <ul>
                @foreach ($item['cdkeys'] as $key)
                    <li>{{ $key }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <p>Nếu bạn cần hỗ trợ kỹ thuật hoặc có bất kỳ thắc mắc nào, đừng ngần ngại liên hệ với chúng tôi.</p>

    <div class="footer">
        &copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
    </div>
</div>
</body>
</html>
