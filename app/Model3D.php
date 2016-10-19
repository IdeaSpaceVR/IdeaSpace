<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model3D extends Model
{

    CONST MODEL_STORAGE_PATH = 'public/assets/user/model/';
    CONST FILE_EXTENSION_DAE = 'dae';
    CONST FILE_EXTENSION_OBJ = 'obj';
    CONST FILE_EXTENSION_MTL = 'mtl';
    CONST FILE_EXTENSION_PLY = 'ply';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'models';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_id_0', 'file_id_1', 'file_id_preview', 'caption', 'description', 'data'
    ];

}
