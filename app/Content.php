<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weight', 'key', 'space_id', 'title'
    ];

}
