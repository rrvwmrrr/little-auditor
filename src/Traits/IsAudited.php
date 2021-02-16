<?php

namespace Rrvwmrrr\Auditor\Traits;

use Illuminate\Support\Facades\Auth;
use Rrvwmrrr\Auditor\Audit;

trait IsAudited {
    public static function bootIsAudited() {
        static::creating(function($model) {
            $auditData = [
                'auditable_id' => $model->id ?? 0,
                'auditable_type' => get_class($model),
                'event' => 'Create',
                'changes' => $model->toJson(),
            ];

            $user = optional(Auth::user()->id);
            if ($user) {
                $auditData['auditor_id'] = $user;
                $auditData['auditor_type'] = config('little-auditor.auditor_model');
            }

            Audit::create($auditData);
        });
    }

    public function auditor() {
        return $this->morphTo(config('little-auditor.auditor_model'), 'auditor');           
    }
}