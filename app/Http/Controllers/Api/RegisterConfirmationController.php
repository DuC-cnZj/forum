<?php

namespace App\Http\Controllers\APi;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))
            ->first();

        if (! $user) {
            return redirect(route('threads'))->with('flash', '邮箱验证失败。');
        }

        $user->confirm();

        return redirect(route('threads'))
            ->with('flash', '激活成功！');
    }
}
