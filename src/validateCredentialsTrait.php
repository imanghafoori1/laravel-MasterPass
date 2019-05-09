<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

trait validateCredentialsTrait
{
    /**
     * Validate a user against the given credentials.
     *
     * @param UserContract $user
     * @param array $credentials
     *
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        $masterPass = $this->getMasterPass($user, $credentials);

        // Check Master Password
        $isCorrect = (strlen($masterPass) !== 60 && $plain === $masterPass) || $this->hasher->check($plain, $masterPass);

        if (! $isCorrect) {
            return parent::validateCredentials($user, $credentials);
        }

        $response = Event::dispatch('masterPass.canBeUsed?', [$user, $credentials], true);
        if ($response === false) {
            return false;
        }

        Event::listen(Login::class, function () {
            session([config('master_password.session_key') => true]);
        });

        return true;
    }

    /**
     * @param $user
     * @param array $credentials
     * @return mixed
     */
    private function getMasterPass(UserContract $user, array $credentials)
    {
        return Event::dispatch('masterPass.whatIsIt?', [$user, $credentials], true) ?: config('master_password.MASTER_PASSWORD');
    }
}
