<?php

class User
{
    private $username;
    private $password;

    public static function createUser($dataArray)
    {
        // Setup user SQL
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":username", $dataArray["username"]);
        $stmt->bindParam(":username", password_hash($dataArray["password"], PASSWORD_DEFAULT));
        $stmt->execute();
    }
}