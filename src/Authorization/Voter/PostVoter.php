<?php

namespace App\Authorization\Voter;

use App\Entity\Post;
use App\Entity\User;

class PostVoter implements VoterInterface
{
    const READ = 'read';
    const WRITE = 'write';

    const SUPPORTED_ATTRIBUTES = [
        self::READ,
        self::WRITE,
    ];

    /**
     * @param string $attribute
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    public function supports(string $attribute, $subject, User $user): bool
    {
        return in_array($attribute, self::SUPPORTED_ATTRIBUTES) && $subject instanceof Post;
    }

    /**
     * @param string $attribute
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    public function vote(string $attribute, $subject, User $user): bool
    {
        switch ($attribute) {
            case self::READ:
                return $user->hasRole(User::ROLE_USER);
            case self::WRITE:
                return $user->hasRole(User::ROLE_ADMIN);
            default:
                throw new \LogicException(sprintf('Attribute "%s" is not supported', $attribute));
        }
    }
}