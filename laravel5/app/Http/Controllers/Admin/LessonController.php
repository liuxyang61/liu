<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LessonRequest;
use App\Model\Lesson;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends CommonController
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
        $field=Lesson::paginate(10);

        return view('admin.lesson.index',compact('field'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.lesson.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request,Lesson $lesson)
    {
        //添加课程内容
        $lesson[ 'title' ]     = $request[ 'title' ];
        $lesson[ 'introduce' ] = $request[ 'introduce' ];
        $lesson[ 'ishot' ]     = $request[ 'ishot' ];
        $lesson[ 'iscommend' ] = $request[ 'iscommend' ];
        $lesson[ 'preview' ]   = $request[ 'preview' ];
        $lesson[ 'click' ]     = $request[ 'click' ];
        $lesson->save();
        //执行视频添加
        $videos = json_decode( $request[ 'videos' ] , true );
        //dd($videos);
        foreach ( $videos as $video ) {
            $lesson->videos()->create( [
                'title'=>$video['title'],
                'path'=>$video['path'],
            ] );
        }

        return redirect( '/admin/lesson' );

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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //这里获取课程旧数据
        $lesson = Lesson::find($id);
        //这里获取视频旧数据
        $videos = json_encode( $lesson->videos()->get()->toArray() , JSON_UNESCAPED_UNICODE );
        return view('admin.lesson.edit',compact('lesson','videos'));
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
        //执行课程信息更新
        $model                = Lesson::find( $id );
        $model[ 'title' ]     = $request[ 'title' ];
        $model[ 'introduce' ] = $request[ 'introduce' ];
        $model[ 'ishot' ]     = $request[ 'ishot' ];
        $model[ 'iscommend' ] = $request[ 'iscommend' ];
        $model[ 'preview' ]   = $request[ 'preview' ];
        $model[ 'click' ]     = $request[ 'click' ];
        $model->save();
        //执行视频更新
        //首先把视频中跟当前课程先关的删除
        Video::where( 'lesson_id' , $id )->delete();
        //执行添加
        $videos = json_decode( $request[ 'videos' ] , true );
        foreach ( $videos as $video ) {
            $model->videos()->create( [
                'title'=>$video['title'],
                'path'=>$video['path'],
            ] );
        }

        return redirect( '/admin/lesson' );


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //删除课程表中的数据
        Lesson::destroy( $id );
        //再执行删除视频数据
        Video::where( 'lesson_id' , $id )->delete();

        return $this->success('删除成功');
    }
}
