<?php

namespace App\Authorization\Voter;

use App\Entity\User;

interface VoterInterface
{
    /**
     * @param string $attribute
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    public function supports(string $attribute, $subject, User $user): bool;

    /**
     * @param string $attribute
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    public function vote(string $attribute, $subject, User $user): bool;
}