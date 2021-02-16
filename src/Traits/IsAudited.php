<?php

namespace Rrvwmrrr\Auditor\Traits;

use Rrvwmrrr\Auditor\Audit;

trait IsAudited {
    public static function bootIsAudited() {
        static::creating(function($model) {
            $auditData = [
                'auditable_id' => $model->id,
                'auditable_type' => get_class($model),
                'event' => 'Create',
                'changes' => $model->toJson(),
            ];

            dd($auditData);
            
            Audit::create([
                'auditable_id' => $model->id,
                'auditable_type' => get_class($model),
                'event' => 'Create',
                'changes' => $model->toJson(),
                'auditor_id' => Auth::user()->id,
                'auditor' => config('little-auditor.auditor_model')
            ]);
            
            dd($model);
        });
    }

    public function auditor() {
        return $this->morphTo(config('little-auditor.auditor_model'), 'auditor');           
    }
}