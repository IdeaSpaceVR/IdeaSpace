<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photosphere extends Model
{

    CONST PHOTOSPHERE_STORAGE_PATH = 'public/assets/user/photospheres/';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photospheres';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id', 'caption', 'description', 'width', 'height', 'data'
    ];

}
