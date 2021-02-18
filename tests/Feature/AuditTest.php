<?php

namespace Rrvwmrrr\Auditor\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Rrvwmrrr\Auditor\Audit;
use Rrvwmrrr\Auditor\Auditor as AuditorConfig;
use Rrvwmrrr\Auditor\Tests\TestCase;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditor;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditable;
use Rrvwmrrr\Auditor\Tests\Support\Models\DifferentAuditor;

class AuditTest extends TestCase
{
    /** @test */
    public function an_audit_belongs_to_an_auditable_model()
    {
        $this->actingAs(Auditor::factory()->create());

        $auditable = Auditable::factory()->create();
        $auditable->name = "New Audit";
        $auditable->save();

        $audit = $auditable->audits->last();

        $retreivedAuditable = $audit->auditable;

        $this->assertEquals($auditable->id, $retreivedAuditable->id);
        $this->assertInstanceOf(Auditable::class, $retreivedAuditable);
        $this->assertInstanceOf(Auditable::class, $auditable);
    }

    /** @test */
    public function an_audit_without_an_auditor_provides_a_default()
    {
        $auditable = Auditable::factory()->create();
        $auditable->name = "New Audit";
        $auditable->save();

        $audit = $auditable->audits->last();

        $retreivedAuditor = $audit->auditor;

        $this->assertEquals($retreivedAuditor->name, "Non auditable user");

    }

    /** @test */
    public function an_audit_has_an_auditor()
    {
        $auditor = Auditor::factory()->create();
        
        $this->actingAs($auditor);

        $auditable = Auditable::factory()->create();
        $auditable->name = "New Audit";
        $auditable->save();

        $audit = $auditable->audits->last();

        $retreivedAuditor = $audit->auditor;

        $this->assertInstanceOf(Auditor::class, $retreivedAuditor);
        $this->assertEquals($auditor->name, $retreivedAuditor->name);

    }
}
