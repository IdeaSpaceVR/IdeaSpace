<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    CONST VIDEO_STORAGE_PATH = 'public/assets/user/videos/';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id', 'caption', 'description', 'width', 'height', 'duration', 'data'
    ];

}
