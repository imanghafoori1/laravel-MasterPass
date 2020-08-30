<?php

namespace Imanghafoori\MasterPass\Tests\Integration;

use Illuminate\Support\Facades\Hash;
use Imanghafoori\MasterPass\Tests\Stubs\UserModel as User;
use Imanghafoori\MasterPass\Tests\TestCase;

class BaseIntegrations extends TestCase
{
    private $user;

    const MASTER_PASS = 'masterpass';

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('auth.guards.custom', [
            'driver' => 'session',
            'provider' => 'users',
        ]);

        config()->set('master_password.MASTER_PASSWORD', Hash::make(self::MASTER_PASS));

        $this->user = factory(User::class)->create(['password' => Hash::make('user_passowrd')]);
    }

    /** @test */
    public function master_pass_session_key_works_correctly_if_user_is_logged_in()
    {
        $this->loginViaMasterPass();

        $this->assertTrue(session(config('master_password.session_key')));

        $this->logout();

        $this->login('wrong_masterpass');

        $this->assertNull(session(config('master_password.session_key')));
    }

    /** @test */
    public function master_pass_session_key_will_be_removed_when_logging_out()
    {
        $this->loginViaMasterPass();

        $this->assertTrue(session(config('master_password.session_key')));

        $this->logout();

        $this->assertNull(session(config('master_password.session_key')));
    }

    /** @test */
    public function is_logged_in_by_master_pass_helper_works_correctly()
    {
        $this->loginViaMasterPass();

        $this->assertTrue(auth()->isLoggedInByMasterPass());

        $this->logout();

        $this->assertFalse(auth()->isLoggedInByMasterPass());
    }

    private function loginViaMasterPass()
    {
        $this->login(self::MASTER_PASS);
    }

    private function logout()
    {
        auth('custom')->logout();
    }

    private function login($password = null)
    {
        auth('custom')->attempt(['username' => $this->user->username, 'password' => $password]);
    }
}
