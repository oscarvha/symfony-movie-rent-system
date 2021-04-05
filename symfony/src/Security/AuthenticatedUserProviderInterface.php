<?php

namespace App\Security;

use App\Entity\User;

interface AuthenticatedUserProviderInterface
{
    public function getUser(): User;
}
