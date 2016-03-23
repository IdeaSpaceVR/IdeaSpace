<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_TRASH = 'trash';

    const MODE_ADD = 'add';
    const MODE_EDIT = 'edit';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spaces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'theme_id', 'uri', 'title', 'status'
    ];

}
