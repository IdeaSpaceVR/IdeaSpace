<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldDataText extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'field_data_text';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'space_id', 'field_control_id', 'text'
    ];

}
