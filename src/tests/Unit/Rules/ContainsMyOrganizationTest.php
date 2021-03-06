<?php

namespace Tests\Unit\Rules;

use App\Orm\Organization;
use App\Rules\ContainsMyOrganization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @package Tests\Unit\Rules
 * @covers \App\Rules\ContainsMyOrganization
 */
class ContainsMyOrganizationTest extends TestCase
{


    use DatabaseMigrations;

    /**
     * @var ContainsMyOrganization
     */
    protected $validator;

    protected function setUp() : void
    {
        parent::setUp();
        $this->validator = new ContainsMyOrganization;
    }

    public function testEmptyListFails()
    {
        $this->assertFalse($this->validator->passes('organizations', []));
    }

    public function testOnlyMyOrganizationPasses()
    {
        $user = $this->actingAsOrganizationMember();

        $this->assertTrue($this->validator->passes('organizations', [
            $user->organizations()->first()->uid
        ]));
    }

    public function testMyOrganizationInLargerListPasses()
    {
        $user = $this->actingAsOrganizationMember();
        $org1 = Organization::factory()->create();
        $org2 = Organization::factory()->create();

        $this->assertTrue($this->validator->passes('organizations', [
            $org1->uid,
            $user->organizations()->first()->uid,
            $org2->uid
        ]));
    }

    public function testMyOrganizationNotInListFails()
    {
        $this->actingAsOrganizationMember();
        $org1 = Organization::factory()->create();
        $org2 = Organization::factory()->create();

        $this->assertFalse($this->validator->passes('organizations', [
            $org1->uid,
            $org2->uid
        ]));
    }

    public function testTakesStringInputAsListOfOneOrgs()
    {
        $user = $this->actingAsOrganizationMember();

        $this->assertTrue($this->validator->passes('organizations', $user->organizations()->first()->uid));
    }
}
