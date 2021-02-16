<?php

namespace Rrvwmrrr\Auditor;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $guarded = [];

    public function auditable() {  
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo('user');
    }
}
