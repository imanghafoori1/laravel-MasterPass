<?php

namespace Imanghafoori\MasterPass\Tests\Stubs;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    protected $table = 'users';
    protected $guarded = [];
}
