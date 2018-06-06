<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

		const FRONTPAGE_DISPLAY_BLANK_PAGE = 'blank-page';
		const FRONTPAGE_DISPLAY_ONE_SPACE = 'one-space';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'namespace', 'key', 'value'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
