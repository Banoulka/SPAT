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

    public function list()
    {
        return $this->roles;
    }

    public function create($roleID)
    {
        QueryBuilder::getInstance()
            ->table("user_roles")
            ->insert([
                "user_id" => $this->user->id(),
                "role_id" => $roleID
            ]);
    }

    public function remove($roleID)
    {
        QueryBuilder::getInstance()
            ->table("user_roles")
            ->remove([
                "user_id" => $this->user->id(),
                "role_id" => $roleID
            ]);
    }
}