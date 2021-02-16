<?php

namespace Rrvwmrrr\Auditor\Traits;

use Illuminate\Support\Facades\Auth;
use Rrvwmrrr\Auditor\Audit;

trait IsAudited {
    protected static $audit = ['creating', 'created', 'updating', 'updated', 'saving', 'saved', 'deleting', 'deleted', 'restoring', 'restored', 'replicating'];
    
    public static function bootIsAudited() {
        foreach(static::$audit as $event) {
            static::{$event}(function($model) {
                $auditData = [
                    'auditable_id' => $model->id ?? 0,
                    'auditable_type' => get_class($model),
                    'event' => 'Create',
                    'changes' => $model->toJson(),
                ];
    
                $user = Auth::user();
                if ($user) {
                    $auditData['auditor_id'] = $user->id;
                    $auditData['auditor_type'] = config('little-auditor.auditor_model');
                }
    
                Audit::create($auditData);
            });
        }
    }

    public function auditor() {
        return $this->morphTo(config('little-auditor.auditor_model'), 'auditor');           
    }
}