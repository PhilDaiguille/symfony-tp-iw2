<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'hashPassword', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'hashPassword', entity: User::class)]
class HashUserPasswordSubscriber
{
    public function __construct(
        protected UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function hashPassword(User $user): void
    {
        $password = $user->getHashPassword();
        if ($password) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword(password: $hashedPassword);
            $user->eraseCredentials();
        }
    }
}
