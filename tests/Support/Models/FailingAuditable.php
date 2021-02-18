<?php

namespace Rrvwmrrr\Auditor\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rrvwmrrr\Auditor\Traits\IsAudited;

class FailingAuditable extends Model
{
    use HasFactory;
    use IsAudited;

    protected $table = "auditables";

    /**
     * The model events to listen for
     *
     * @var array
     */
    protected $audit = [
        'event_that_doesnt_exist',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];
}
