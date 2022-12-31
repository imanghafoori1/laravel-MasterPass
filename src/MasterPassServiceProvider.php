<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class MasterPassServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__.'/config/master_password.php' => config_path('master_password.php')], 'master_password');

        $this->registerDirectives();
        Event::listen(Logout::class, function () {
            session()->remove(config('master_password.session_key'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("Laravel\Passport\Bridge\UserRepository", PassportUserRepository::class);
        $this->registerAuthProviders();

        $this->mergeConfigFrom(__DIR__.'/config/master_password.php', 'master_password');
        if (config('master_password.MASTER_PASSWORD')) {
            $this->changeUsersDriver();
        }

        $this->app->booted(function () {
            $this->defineIsUsingMasterPass();
        });
    }

    /**
     * If the users driver is set to eloquent or database
     * it changes to 'eloquent' to eloquentMasterPass and
     * 'database' to databaseMasterPass,
     *  otherwise it does nothing.
     *
     * @return null
     */
    private function changeUsersDriver()
    {
        foreach (config('auth.providers', []) as $providerName => $providerConfig) {
            $driver = $providerConfig['driver'];

            if (in_array($driver, ['eloquent', 'database'])) {
                config()->set("auth.providers.$providerName.driver", $driver.'MasterPassword');
            }
        }
    }

    private function registerAuthProviders()
    {
        \Auth::provider('eloquentMasterPassword', function ($app, array $config) {
            return new MasterPassEloquentUserProvider($app['hash'], $config['model']);
        });

        \Auth::provider('databaseMasterPassword', function ($app, array $config) {
            $connection = $app['db']->connection();

            return new MasterPassDatabaseUserProvider($connection, $app['hash'], $config['table']);
        });
    }

    private function defineIsUsingMasterPass()
    {
        foreach (array_keys(config('auth.guards')) as $guard) {
            if (($authGuard = Auth::guard($guard)) instanceof StatefulGuard) {
                $authGuard->macro('isLoggedInByMasterPass', function () {
                    return session(config('master_password.session_key'), false);
                });
            }
        }
    }

    private function registerDirectives()
    {
        Blade::directive('isLoggedInByMasterPass', function ($guard = null) {
            return "<?php if(Auth::isLoggedInByMasterPass({$guard})): ?>";
        });
    }
}
