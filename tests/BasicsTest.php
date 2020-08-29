<?php

namespace Imanghafoori\MasterPass\Tests;

use Imanghafoori\MasterPass\Models\User;

class BasicsTest extends TestCase
{
    /** @test */
    public function young_custom_method()
    {
        $user = factory(User::class)->create();

    }
}
