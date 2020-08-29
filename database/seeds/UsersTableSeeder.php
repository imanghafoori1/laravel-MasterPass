<?php

use Illuminate\Database\Seeder;
use Imanghafoori\MasterPass\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->getStub();

        foreach ($users as $user) {
            factory(User::class)->create($user);
        }
    }

    private function getStub()
    {
        return [
            [
                'name' => 'mehrad',
                'email' => 'mehrad@example.com',
                'username' => 'mehrad',
                'age' => 20,
                'created_at' => '2020-09-01',
                'updated_at' => '2020-09-01',
            ]
        ];
    }
}
