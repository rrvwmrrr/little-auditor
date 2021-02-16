<?php

namespace Rrvwmrrr\Auditor;

trait isAudited {
    public static function bootIsAudited() {
        static::creating(function($model) {

        });
    }
}