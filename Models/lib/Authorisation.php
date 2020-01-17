<?php

class Authorisation
{
    public static function hasAuth($permission)
    {
        if (Authentication::isMocking()) {
            return Authentication::User()->role()->hasPermission($permission)
                || Authentication::mockedUser()->role()->hasPermission($permission);
        } else {
            return Authentication::User()->role()->hasPermission($permission);
        }
    }
}