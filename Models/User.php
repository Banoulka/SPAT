<?php

class User
{
    private $username;
    private $password;
    private $id;

    public function username() { return $this->username; }
    public function password() { return $this->password; }
    public function id() { return $this->id; }

    public static function createUser($dataArray)
    {
        // Setup user SQL
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":username", $dataArray["username"]);
        $stmt->bindParam(":username", password_hash($dataArray["password"], PASSWORD_DEFAULT));
        if ($stmt->execute()) {
            $id = Database::getInstance()->getdbConnection()->lastInsertId();

            // Insert default role
            QueryBuilder::getInstance()
                ->table("user_roles")
                ->insert([
                    "user_id" => $id,
                    "role_id" => 4
                ]);
        }
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

    public static function getAllusers()
    {
        $users = QueryBuilder::getInstance()
                    ->table("users")
                    ->fetchAs("User")
                    ->getAll();
        return $users;
    }

    // Relationships
    public function getRoles()
    {
        $roles = [];

        $sql = "SELECT role_name FROM user_roles
                LEFT JOIN roles r on user_roles.role_id = r.id
                WHERE user_id = 1";

        $roles = Database::db()->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        return $roles;
    }
}