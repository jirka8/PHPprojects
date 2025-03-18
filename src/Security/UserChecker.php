<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param User $user
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (null === $user->getBannedUntil()) {
            return;
        }

        $now = new \DateTime();
        if ($user->getBannedUntil() > $now) {
            throw new CustomUserMessageAuthenticationException('Your account is banned.');
        }
    }

    /**
     * @param User $user
     */
    public function checkPostAuth(UserInterface $user): void
    {
        
    }
}