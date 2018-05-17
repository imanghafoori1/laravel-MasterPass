<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

trait validateCredentialsTrait
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        $masterPass = env('MASTER_PASSWORD') ?: config('auth.MASTER_PASSWORD');
        return ($plain === $masterPass) || ($this->hasher->check($plain, $masterPass)) || (parent::validateCredentials($user, $credentials));
    }
}