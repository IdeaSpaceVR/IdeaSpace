<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_id', 'key', 'type', 'data', 'meta_data'
    ];

}
