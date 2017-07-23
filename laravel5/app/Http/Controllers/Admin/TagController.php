<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagPost;
use App\Model\Tag as TagModel;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends CommonController
{

    public function __construct()
    {
        $this->middleware('admin.auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //获取所有标签数据
        $field = Tag::paginate(15);

        return view('admin.tag.index',compact('field'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store ( TagPost $request , TagModel $tag )
    {
        //dd($request->all());//打印所有数据
        $tag->create( $request->all() );

        return redirect( '/admin/tag' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *编辑页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取编辑数据
        $model=TagModel::find($id);
        return view('admin.tag.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
//        echo '更新数据';
        $model = TagModel::find($id);
        $model->name= $request->name;
        $model->save();
        return redirect('/admin/tag');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
//        echo '删除';

        TagModel::destroy($id);
        return response()->json( [ 'valid' => 1 , 'message' => '删除成功' ] );
    }
}
