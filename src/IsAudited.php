<?php

namespace Rrvwmrrr\Auditor;

trait IsAudited {
    public static function bootIsAudited() {
        static::creating(function($model) {
            dd($model);
        });
    }
}