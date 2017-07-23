<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $guarded=[];

    //课程视频
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
