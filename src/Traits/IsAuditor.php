<?php

namespace Rrvwmrrr\Auditor\Traits;

use Rrvwmrrr\Auditor\Audit;

trait IsAuditor {
    public function audits() {
        return $this->morphMany(Audit::class, 'auditorable');
    }
}