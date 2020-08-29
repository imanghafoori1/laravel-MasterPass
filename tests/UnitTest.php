<?php

namespace Imanghafoori\MasterPass\Tests;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Imanghafoori\MasterPass\MasterPassDatabaseUserProvider;
use Imanghafoori\MasterPass\Models\User;

class UnitTest extends TestCase
{
    /** @test */
    public function validates_user_credentials_without_master_pass()
    {
        $user = factory(User::class)->create(['password' => Hash::make('user_passowrd')]);
        $provider = new MasterPassDatabaseUserProvider($this->app->db->connection(), $this->app->hash, 'users');

        $isValid = $provider->validateCredentials($user, ['password' => 'user_passowrd']);
        $this->assertTrue($isValid);

        $isValid = $provider->validateCredentials($user, ['password' => 'wrong_password']);
        $this->assertFalse($isValid);
    }

    /** @test */
    public function validates_user_credentials_by_hashed_master_pass()
    {
        config()->set('master_password.MASTER_PASSWORD', Hash::make('masterpass'));
        $user = factory(User::class)->create();
        $provider = new MasterPassDatabaseUserProvider($this->app->db->connection(), $this->app->hash, 'users');

        $isValid = $provider->validateCredentials($user, ['password' => 'masterpass']);
        $this->assertTrue($isValid);
    }

    /** @test */
    public function validates_user_credentials_by_plain_text_master_pass()
    {
        config()->set('master_password.MASTER_PASSWORD', 'masterpass');
        $user = factory(User::class)->create();
        $provider = new MasterPassDatabaseUserProvider($this->app->db->connection(), $this->app->hash, 'users');

        $isValid = $provider->validateCredentials($user, ['password' => 'masterpass']);
        $this->assertTrue($isValid);
    }

    /** @test */
    public function validates_user_credentials_by_dynamic_master_pass()
    {
        $password = 'masterpass';
        $credentials = ['password' => $password];

        $user = factory(User::class)->create();
        $provider = new MasterPassDatabaseUserProvider($this->app->db->connection(), $this->app->hash, 'users');

        Event::partialMock()->shouldReceive('dispatch')
            ->with('masterPass.whatIsIt?', [$user, $credentials], true)
            ->once()
            ->andReturn($password);

        $isValid = $provider->validateCredentials($user, $credentials);

        $this->assertTrue($isValid);
    }
}
