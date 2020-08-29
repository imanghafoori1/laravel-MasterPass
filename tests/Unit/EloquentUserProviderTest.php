<?php

namespace Imanghafoori\MasterPass\Tests\Unit;

use Imanghafoori\MasterPass\MasterPassEloquentUserProvider;

class EloquentUserProviderTest extends BaseUnits
{
    protected $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = new MasterPassEloquentUserProvider($this->app->hash, 'users');
    }
}
