<?php

namespace Rrvwmrrr\Auditor\Tests\Support\Models;

use Database\Factories\AuditorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rrvwmrrr\Auditor\Traits\IsAudited;

class AuditableSoftDeletes extends Model
{
    use HasFactory;
    use IsAudited;
    use SoftDeletes;

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
