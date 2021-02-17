<?php

namespace Rrvwmrrr\Auditor;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $guarded = [];

    public function auditable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function auditor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Auditor::$auditorModel)->withDefault([
            'name' => 'Non auditable user',
        ]);
    }
}
