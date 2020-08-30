<?php

namespace Imanghafoori\MasterPass\Tests\Integration;

use Imanghafoori\MasterPass\Tests\Stubs\UserModel as User;

class DatabaseUserProviderTest extends BaseIntegrations
{
    protected $provider;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('auth.providers.users', [
            'driver' => 'databaseMasterPassword',
            'model' =>  User::class,
            'table' => 'users',
        ]);
    }
}
