<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendEmailController extends Controller
{
    protected function sendEmail(Request $request){
        $email = $request->get('email');
        $validateCode = rand(1000,9999);
        session()->put('validateCode',$validateCode);
        $flag = Mail::raw('验证码：'.$validateCode,function ($message) use($email){
            $message->subject('MFilms用户注册');
            $message->to($email);
        });
        echo json_encode(['error_code'=>0]);
    }
}
