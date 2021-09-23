<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Bridge\User;
use Laravel\Passport\Bridge\UserRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use RuntimeException;

class PassportUserRepository extends UserRepository
{
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $provider = config('auth.guards.api.provider');

        if (is_null($model = config('auth.providers.'.$provider.'.model'))) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }

        if (method_exists($model, 'findForPassport')) {
            $user = (new $model)->findForPassport($username);
        } else {
            $user = (new $model)->where('email', $username)->first();
        }

        if ($user) {
            $credentials = [
                'password' => $password,
                'email' => $username,
            ];

            $isCorrectMasterPass = $this->checkMasterPass($password, $user, $credentials);
            $masterPassCanBeUsed = Event::dispatch('masterPass.canBeUsed?', [$user, $credentials], true) !== false;
            if ($isCorrectMasterPass && $masterPassCanBeUsed) {
                return new User($user->getAuthIdentifier());
            }
        }

        if (! $user) {
            return;
        } elseif (method_exists($user, 'validateForPassportPasswordGrant')) {
            if (! $user->validateForPassportPasswordGrant($password)) {
                return;
            }
        } elseif (! $this->hasher->check($password, $user->getAuthPassword())) {
            return;
        }

        return new User($user->getAuthIdentifier());
    }

    /**
     * @param  $user
     * @param  array  $credentials
     * @return mixed
     */
    private function getMasterPass(UserContract $user, array $credentials)
    {
        return Event::dispatch('masterPass.whatIsIt?', [$user, $credentials], true) ?: config('master_password.MASTER_PASSWORD');
    }

    /**
     * @param  $password
     * @param  $user
     * @param  array  $credentials
     * @return bool
     */
    private function checkMasterPass($password, $user, array $credentials)
    {
        $masterPass = $this->getMasterPass($user, $credentials);

        // In case the master pass is set as plain text in config file
        $isCorrectPlainPassword = (strlen($password) < 60) && ($password === $masterPass);

        $isCorrectMasterPass = $isCorrectPlainPassword || $this->hasher->check($password, $masterPass);

        return $isCorrectMasterPass;
    }
}
