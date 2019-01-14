<?php

use Imanghafoori\MasterPass\MasterPassServiceProvider;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [MasterPassServiceProvider::class];
    }
}
