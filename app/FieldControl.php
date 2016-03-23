<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldControl extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'field_controls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'space_id', 'key', 'type', 'table'
    ];

}
