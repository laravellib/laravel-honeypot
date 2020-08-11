<?php

namespace codicastudio\Honeypot\Tests;

use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\View;
use codicastudio\Honeypot\HoneypotServiceProvider;
use codicastudio\Honeypot\Tests\TestClasses\FakeEncrypter;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithContainer;

    protected $testNow = true;

    public function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/views');

        if ($this->testNow) {
            $this->setNow(2019, 1, 1);
        }

        $this->swap('encrypter', new FakeEncrypter());
    }

    protected function getPackageProviders($app)
    {
        return [HoneypotServiceProvider::class];
    }

    protected function setNow($year, int $month = 1, int $day = 1)
    {
        $newNow = $year instanceof CarbonInterface
            ? $year->copy()
            : Date::createFromDate($year, $month, $day);

        $newNow = $newNow->startOfDay();

        Date::setTestNow($newNow);
    }
}
