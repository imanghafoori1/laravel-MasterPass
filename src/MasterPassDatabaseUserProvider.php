<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Auth\DatabaseUserProvider;

class MasterPassDatabaseUserProvider extends DatabaseUserProvider
{
    use validateCredentialsTrait;
}
