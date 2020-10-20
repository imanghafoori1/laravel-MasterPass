<?php

namespace Imanghafoori\MasterPass\Tests;

use Imanghafoori\MasterPass\MasterPassServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $compiler;

    protected function getPackageProviders($app)
    {
        return [MasterPassServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->withFactories(__DIR__.'/../database/factories');
        $this->compiler = app('blade.compiler');
    }
}
