<?php

require_once __DIR__ . "/../User.php";

class Authentication {

    private static $sessionID = "user";

    public static function logonUser(User $user)
    {
        Session::setSession(Authentication::$sessionID, serialize($user));
    }

    /**
     * @return User
     */
    public static function User()
    {
        if (!Authentication::isLoggedIn()) {
            return null;
        }
        return unserialize(Session::getSession(Authentication::$sessionID));
    }

    public static function validateAndLoginUser($username, $password)
    {
        $errors = [];

        $user = User::findByUsername($username);

        if ($user) {
            if (password_verify($password, $user->password())) {
                // Login Successfull
                Authentication::logonUser($user);
            } else {
                array_push($errors, "Username or password does not match");
            }
        }
        else {
            $waitingUser = User::getUserRequestByUsername($username);
            if ($waitingUser) {
                if (password_verify($password, $waitingUser->password())) {
                    array_push($errors, "Your account is currently waiting for approval by an admin");
                } else {
                    array_push($errors, "Username or password does not match");
                }
            } else {
                array_push($errors, "Username does not exist");
            }
        }
        return $errors;
    }

    public static function isLoggedIn()
    {
        return Session::isSet(Authentication::$sessionID);
    }
}