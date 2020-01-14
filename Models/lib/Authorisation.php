<?php

class Authorisation
{
    public static function hasAuth($permission)
    {
        return Authentication::User()->role()->hasPermission($permission);
    }
}