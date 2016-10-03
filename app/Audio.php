<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{

    CONST AUDIO_STORAGE_PATH = 'public/assets/user/audio/';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'audio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id', 'caption', 'description', 'data'
    ];

}
