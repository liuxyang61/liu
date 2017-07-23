<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Play extends Common
{

    public function index()
    {
        $id =  input('param.order_id');
        return view('',compact('id'));
    }
}
