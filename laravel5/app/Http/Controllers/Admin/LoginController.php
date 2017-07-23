<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    /***
     * 登录页面加载
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        $status = Auth::guard('admin')->attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ]);
        if($status){
            //登录成功，新建EntryController,配相对应的理由
            return redirect('/admin/index');
        }
        return redirect('/admin/login')->with('error','用户名或者密码不正确');
    }

}
