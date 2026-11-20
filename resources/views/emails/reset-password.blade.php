<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f4f4f4; padding: 30px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="padding: 30px 40px; text-align: center;">
                        <img src="{{ config('app.url') }}/assets/images/logo_desktop.png" alt="{{ config('app.name') }}" style="max-height: 60px; margin-bottom: 20px;">
                        <h2 style="color: #333333; font-family: sans-serif;">Yêu cầu đặt lại mật khẩu</h2>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 40px 30px;">
                        <p style="color: #555555; font-size: 16px;">
                            Xin chào {{ $user->name ?? 'bạn' }},
                        </p>
                        <p style="color: #555555; font-size: 16px;">
                            Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại <strong>{{ config('app.name') }}</strong>.
                        </p>
                        <p style="color: #555555; font-size: 16px;">
                            Nhấn vào nút bên dưới để tạo mật khẩu mới:
                        </p>
                        
                        @component('mail::button', ['url' => $url, 'color' => 'primary'])
                            Đặt lại mật khẩu
                        @endcomponent
                        
                        <p style="color: #555555; font-size: 16px;">
                            Liên kết này sẽ hết hạn sau 60 phút kể từ khi được gửi.
                        </p>
                        <p style="color: #999999; font-size: 14px;">
                            Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bỏ qua email này.
                        </p>
                        <hr style="margin: 30px 0;">
                        <p style="color: #999999; font-size: 13px; text-align: center;">
                            Cảm ơn bạn đã sử dụng dịch vụ của {{ config('app.name') }}.<br>
                            Nếu cần hỗ trợ, vui lòng liên hệ chúng tôi qua email hoặc hotline.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>