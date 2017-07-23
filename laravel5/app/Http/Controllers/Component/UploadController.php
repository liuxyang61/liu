<?php

namespace App\Http\Controllers\Component;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    //

    public function uploader(Request $request)
    {
//        return $request->file;
        $upload = $request->file;
        //上传判断
        if ( $upload->isValid() ) {
            $path = $upload->store( date( 'ymd' ) , 'attachment' );
            //dd( $path );
            return [ 'valid' => 1, 'message' => asset('attachment/' . $path) ];
        }
        return [ 'valid' => 0 , 'message' => '上传失败' ];

    }
    //获取文件列表
    public function filesLists() {

        return [ 'data' => '', 'page' => '' ] ;
    }
}
