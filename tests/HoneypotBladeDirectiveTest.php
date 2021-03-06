<?php

namespace codicastudio\Honeypot\Tests;

use Carbon\CarbonImmutable;
use Illuminate\Support\DateFactory;
use codicastudio\Snapshots\MatchesSnapshots;

class HoneypotBladeDirectiveTest extends TestCase
{
    use MatchesSnapshots;

    protected $testNow = false;

    public function setUp(): void
    {
        parent::setUp();

        config()->set('honeypot.randomize_name_field_name', false);
    }

    /** @test */
    public function the_honeypot_blade_directive_renders_correctly()
    {
        $this->setNow(2019, 1, 1);

        $renderedView = view('honeypot')->render();

        $this->assertMatchesSnapshot($renderedView);
    }

    /** @test */
    public function the_honeypot_blade_directive_renders_correctly_when_using_CarbonImmutable()
    {
        DateFactory::use(CarbonImmutable::class);
        $this->setNow(2019, 1, 1);

        $renderedView = view('honeypot')->render();

        $this->assertMatchesSnapshot($renderedView);

        DateFactory::use(DateFactory::DEFAULT_CLASS_NAME);
    }
}
