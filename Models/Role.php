<?php


class Role
{
    public static function addRole($dataArr)
    {
        $sql = "INSERT INTO roles (role_name) VALUES (:roleName)";
    }
}