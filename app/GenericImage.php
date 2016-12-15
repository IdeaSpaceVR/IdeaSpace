<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenericImage extends Model
{

    CONST IMAGE_STORAGE_PATH = 'public/assets/user/images/';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id', 'caption', 'description', 'width', 'height', 'data'
    ];

}
