<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Support\ServiceProvider;

class MasterPassServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Auth::provider('eloquentMasterPass', function ($app, array $config) {
            return new MasterPassEloquentUserProvider($app['hash'], $config['model']);
        });

        \Auth::provider('databaseMasterPass', function ($app, array $config) {
            $connection = $app['db']->connection();

            return new MasterPassDatabaseUserProvider($connection, $app['hash'], $config['table']);
        });

        if (env('MASTER_PASSWORD', false)) {
            $this->changeUsersDriver();
        }
    }

    /**
     * If the users driver is set to eloquent or database
     * it changes to 'eloquent' to eloquentMasterPass and
     * 'database' to databaseMasterPass,
     *  otherwise it does nothing
     *
     * @return null
     */
    private function changeUsersDriver()
    {
        $driver = config()->get('auth.providers.users.driver');
        if (in_array($driver, ['eloquent', 'database',])) {
            config()->set('auth.providers.users.driver', $driver.'MasterPass');
        }
    }
}
