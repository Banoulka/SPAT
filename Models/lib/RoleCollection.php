<?php


class RoleCollection
{
    private $user;
    private $roles = [];

    public function __construct(User $user, array $roles)
    {
        $this->user = $user;
        $this->roles = $roles;
    }

    public function __get($name)
    {
        return $this->roles;
    }
}