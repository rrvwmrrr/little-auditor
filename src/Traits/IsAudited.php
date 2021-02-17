<?php

namespace Rrvwmrrr\Auditor\Traits;

use Illuminate\Support\Facades\Auth;
use ReflectionClass;
use Rrvwmrrr\Auditor\Audit;
use Rrvwmrrr\Auditor\Exceptions\AuditException;

trait IsAudited
{
    protected static $audits = ['creating', 'created', 'updating', 'updated', 'saving', 'saved', 'deleting', 'deleted', 'restoring', 'restored', 'replicating'];
    protected static $softDeleteEvents = ['restoring', 'restored'];

    public static function bootIsAudited()
    {
        $usingSoftDeletes = in_array('SoftDeletes', class_uses(static::class));
        $classAudits = static::getAudits(static::class);
        
        foreach ($classAudits as $event) {
            if (! in_array($event, static::$audits)) {
                throw AuditException::eventNotCovered($event);
            }
            if (! $usingSoftDeletes && in_array($event, static::$softDeleteEvents)) {
                continue;
            }
            
            static::{$event}(function ($model) use ($event) {
                $auditData = [
                    'auditable_id' => $model->id ?? 0,
                    'auditable_type' => get_class($model),
                    'event' => ucfirst($event),
                    'state' => $model->toJson(),
                ];
    
                $user = Auth::user();
                if ($user) {
                    $auditData['auditor_id'] = $user->id;
                }
    
                Audit::create($auditData);
            });
        }
    }

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
    }

    private static function getAudits($class)
    {
        $reflectedClass = new ReflectionClass($class);
        $properties = collect($reflectedClass->getProperties())->where('name', 'audit');
        if ($properties->count() == 0) {
            return static::$audits;
        }

        $property = $properties->first();
        $property->setAccessible(true);

        return $property->getValue(new $class);
    }
}
