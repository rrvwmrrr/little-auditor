<?php

namespace Rrvwmrrr\Auditor\Traits;

trait IsAudited {
    public static function bootIsAudited() {
        static::creating(function($model) {
            dd($model);
        });
    }

    public function auditor() {
        return $this->morphTo();           
    }
}