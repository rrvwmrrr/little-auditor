<?php

namespace Rrvwmrrr\Auditor\Traits;

use Rrvwmrrr\Auditor\Audit;

trait IsAuditor {
    public static function bootIsAuditor() {
        
    }

    public function audits() {
        return $this->morphMany(Audit::class, 'auditorable');
    }
}