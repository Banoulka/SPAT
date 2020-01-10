<?php


class Role
{
    public static function addRole($roleName)
    {
        QueryBuilder::getInstance()
            ->table("roles")
            ->insert([
                "role_name" => $roleName,
                "editable" => true
            ]);
    }

    public static function removeRole($roleID)
    {
        QueryBuilder::getInstance()
            ->table("roles")
            ->remove(["id" => $roleID]);
    }

    public static function allRoles()
    {
        return QueryBuilder::getInstance()->table("roles")
                ->fetchAs("Role")
                ->orderby("role_name")
                ->getAll();
    }
}