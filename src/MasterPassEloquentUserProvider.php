<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Auth\EloquentUserProvider as LaravelUserProvider;

class MasterPassEloquentUserProvider extends LaravelUserProvider
{
    use validateCredentialsTrait;
}
