<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videosphere extends Model
{

    CONST VIDEOSPHERE_STORAGE_PATH = 'public/assets/user/videospheres/';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'videospheres';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id', 'caption', 'description', 'width', 'height', 'duration', 'data'
    ];

}
