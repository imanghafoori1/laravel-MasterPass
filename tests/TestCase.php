<?php

namespace Imanghafoori\MasterPass\Tests;

use Illuminate\Support\Facades\Route;
use Imanghafoori\MassterPass\Models\User;
use Imanghafoori\MasterPass\MasterPassServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [MasterPassServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->withFactories(__DIR__.'/../database/factories');
//        $this->artisan('db:seed');

        $this->defineDefaultRoute();
    }

    private function defineDefaultRoute()
    {
        Route::get('/', function () {
            return User::select('name')->filter()->get();
        });
    }
}