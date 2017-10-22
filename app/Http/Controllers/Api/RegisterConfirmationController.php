<?php

namespace App\Http\Controllers\APi;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();

        return redirect('/threads')
            ->with('flash', '激活成功！');
    }
}
