<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenericFile extends Model
{
    const STATUS_PUBLISHED = 'published';


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'filename', 'uri', 'filemime', 'filesize', 'filename_orig', 'status'
    ];

}
