<?php

class User
{
    private $username;
    private $password;

    public function username() { return $this->username; }
    public function password() { return $this->password; }

    public static function createUser($dataArray)
    {
        // Setup user SQL
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":username", $dataArray["username"]);
        $stmt->bindParam(":username", password_hash($dataArray["password"], PASSWORD_DEFAULT));
        $stmt->execute();
    }

    /**
     * @param $username
     *
     * @return User
     */
    public static function findByUsername($username)
    {
        $foundUser = QueryBuilder::getInstance()
            ->table("users")
            ->where("username", $username)
            ->fetchAs("User")
            ->first();
        return $foundUser;
    }
}