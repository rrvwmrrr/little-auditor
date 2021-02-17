<?php

namespace Rrvwmrrr\Auditor\Traits;

use Rrvwmrrr\Auditor\Audit;

trait IsAuditor
{
    public function audits()
    {
        return $this->hasMany(Audit::class);
    }
}
