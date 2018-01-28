<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Texture extends Model
{

    CONST FILE_EXTENSION_PNG = 'png';
    CONST FILE_EXTENSION_JPG = 'jpg';
    CONST FILE_EXTENSION_GIF = 'gif';
    CONST FILE_EXTENSION_TGA = 'tga';
    CONST FILE_EXTENSION_TIF = 'tif';
    CONST FILE_EXTENSION_TIFF = 'tiff';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'textures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id', 'model_id', 'data'
    ];

}
