<?php

namespace Rrvwmrrr\Auditor\Tests\Feature;

use Rrvwmrrr\Auditor\Audit;
use Rrvwmrrr\Auditor\Exceptions\AuditException;
use Rrvwmrrr\Auditor\Tests\TestCase;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditor;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditable;
use Rrvwmrrr\Auditor\Tests\Support\Models\FailingAuditable;
use Rrvwmrrr\Auditor\Tests\Support\Models\NotAuditable;

class AuditableTest extends TestCase
{
    /** @test */
    public function a_model_isnt_audited_unless_registered()
    {
        $this->actingAs(Auditor::factory()->create());

        $notAuditable = NotAuditable::factory()->create();
        $audits = Audit::where('auditable_id', $notAuditable->id)->where('auditable_type', NotAuditable::class)->count();

        $this->assertEquals(0, $audits);
    }

    /** @test */
    public function a_model_with_invalid_audits_will_cause_an_exception()
    {
        $this->actingAs(Auditor::factory()->create());

        $this->expectException(AuditException::class);
        $this->expectExceptionMessage("The auditor does not cover the `event_that_doesnt_exist` event you've requested");
        $failingAuditable = FailingAuditable::factory()->make();
    }
    
    /** @test */
    public function an_auditable_model_is_audited()
    {
        $this->actingAs(Auditor::factory()->create());

        $auditable = Auditable::factory()->create();
        $audits = $auditable->audits;

        $this->assertInstanceOf(Audit::class, $audits->first());
    }
}
