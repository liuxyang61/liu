<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EntryController extends CommonController
{
    public function __construct()
    {
        $this->middleware('admin.auth');

    }
    //

    /***
     * 首页展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('admin.entry.index');
    }

    /***
     * 加载修改密码页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pass()
    {

        return view('admin.entry.pass');
    }


    /***
     * 修改密码方法
     */
    public function changePass(AdminPost $request)
    {
        $model = Auth::guard('admin')->user();
        //dd($model);
        $model->password = bcrypt($request->input('password'));
        $model->save();
        flash()->overlay('密码修改成功', '后盾人 - 温馨提示');
        return redirect()->back();
    }



    /***
     *
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('admin/login');

    }


}
