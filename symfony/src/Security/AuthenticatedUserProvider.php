<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthenticatedUserProvider implements AuthenticatedUserProviderInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * AuthenticatedUserProvider constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getAuthUser(): AuthUser
    {
        $token = $this->tokenStorage->getToken();
        /** @var AuthUser $authUser */
        $authUser = $token->getUser();

        return $authUser;
    }

    public function getUser(): User
    {
        return $this->getAuthUser()->getUser();
    }
}
