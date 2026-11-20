<?php

namespace App\Http\Controllers;

use App\Core\Enums\DefaultStatus;
use App\Core\Enums\ProxyStatus;
use App\Core\Enums\Setting\SettingGroup;
use App\Models\Contact;
use App\Models\Proxy;
use App\Models\ProxyCategory;
use App\Models\ProxyType;
use App\Models\QA;
use App\Models\Setting;
use App\Services\AuthService;
use App\Services\ProxyService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function formContact(Request $request) {
        return view("public.contactForm");
    }

    public function contactPost(Request $request) {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'subject.required' => 'Vui lòng nhập tiêu đề.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 10 ký tự.',
        ]);

        $contact = Contact::create([
            'fullname' => $validatedData['fullname'],
            'email' => $validatedData['email'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('home')->with('success', 'Gửi thành công!');
    }
}
