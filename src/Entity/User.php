<?php

namespace App\Entity;

class User
{
    const ROLE_USER = 'role_user';
    const ROLE_ADMIN = 'role_admin';

    /**
     * @var string
     */
    private $username;

    /**
     * @var array
     */
    private $roles = [];

    public function __construct()
    {
        // Assign role user to all users
        $this->addRole(self::ROLE_USER);
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function addRole(string $role): self
    {
        if(!$this->hasRole($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }
}