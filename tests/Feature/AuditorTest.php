<?php

namespace Rrvwmrrr\Auditor\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Rrvwmrrr\Auditor\Audit;
use Rrvwmrrr\Auditor\Auditor as AuditorConfig;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditable;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditor;
use Rrvwmrrr\Auditor\Tests\Support\Models\DifferentAuditor;
use Rrvwmrrr\Auditor\Tests\TestCase;

class AuditorTest extends TestCase
{
    /** @test */
    public function we_can_get_an_auditor_from_auth_user()
    {
        $this->actingAs(Auditor::factory()->make());
        $this->assertInstanceOf(Auditor::class, Auth::user());
    }

    /** @test */
    public function an_auditor_can_have_audits()
    {
        $this->actingAs(Auditor::factory()->create());

        Auditable::factory()->create();
        
        $auditor = Auditor::find(1);
        $audit = Audit::find(1);

        $this->assertEquals(4, $auditor->audits->count());
        $this->assertInstanceOf(Audit::class, $auditor->audits->first());
        $this->assertEquals($audit, $auditor->audits->first());
        $this->assertEquals($auditor->id, $auditor->audits->first()->auditor_id);
    }

    /** @test */
    public function the_auditor_model_can_be_changed()
    {
        $newModel = DifferentAuditor::class;

        $this->assertNotEquals($newModel, AuditorConfig::$auditorModel);

        AuditorConfig::$auditorModel = $newModel;

        $this->assertEquals(AuditorConfig::$auditorModel, $newModel);
    }
}
