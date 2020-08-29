<?php

namespace Imanghafoori\MasterPass\Tests\Unit;

use Imanghafoori\MasterPass\MasterPassDatabaseUserProvider;

class DatabaseUserProviderTest extends BaseUnits
{
    protected $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = new MasterPassDatabaseUserProvider($this->app->db->connection(), $this->app->hash, 'users');
    }
}
