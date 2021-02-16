<?php

namespace Rrvwmrrr\Auditor\Traits;

use Illuminate\Support\Facades\Auth;
use ReflectionClass;
use Rrvwmrrr\Auditor\Audit;

trait IsAudited {
    protected static $audits = ['creating', 'created', 'updating', 'updated', 'saving', 'saved', 'deleting', 'deleted', 'restoring', 'restored', 'replicating'];
    protected static $softDeleteEvents = ['restoring', 'restored'];

    public static function bootIsAudited() {
        $usingSoftDeletes = in_array('SoftDeletes', class_uses(static::class));
        
        $classAudits = static::getAudits(static::class);
        
        foreach(static::$audits as $event) {
            if ($usingSoftDeletes && in_array($event, static::$softDeleteEvents)) {
                continue;
            }
            
            static::{$event}(function($model) use ($event) {
                $auditData = [
                    'auditable_id' => $model->id ?? 0,
                    'auditable_type' => get_class($model),
                    'event' => ucfirst($event),
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

    private static function getAudits($class) {
        $reflectedClass = new ReflectionClass($class);
        $properties = collect($reflectedClass->getProperties())->where('name', 'audit');
        dd($properties);
    }
}