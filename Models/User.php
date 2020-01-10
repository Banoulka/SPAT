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
        $password = password_hash($dataArray["password"], PASSWORD_DEFAULT);

        // Setup user SQL
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":username", $dataArray["username"]);
        $stmt->bindParam(":password", $password);
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

    public static function createAdminRequest($dataArray)
    {
        $sql = "INSERT INTO admin_requests (username, password) VALUES (:username, :password)";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":username", $dataArray["username"]);
        $stmt->bindParam(":password", password_hash($dataArray["password"], PASSWORD_DEFAULT));

    }

    public static function removeUser($userName)
    {
        QueryBuilder::getInstance()
            ->table("users")
            ->remove(["username" => $userName]);
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

    /**
     * @return User[]
     */
    public static function getAllusers()
    {
        $users = QueryBuilder::getInstance()
                    ->table("users")
                    ->fetchAs("User")
                    ->getAll();
        return $users;
    }

    // Relationships

    public function role()
    {
        $sql = "SELECT role_name FROM user_roles
                LEFT JOIN roles r on user_roles.role_id = r.id
                WHERE user_id = $this->id";
        return Database::db()->query($sql)->fetch(PDO::FETCH_COLUMN);
    }

    public function isRole($roleName)
    {
        $role = $this->role();
        return $role === $roleName;
    }

    public function isAdmin()
    {
        return $this->isRole("Admin");
    }

    public function teams()
    {
        $sql = "SELECT group_name FROM group_members
                LEFT JOIN groups t on group_members.team_id = t.id
                WHERE user_id = $this->id";

        $groups = Database::db()->query($sql)->fetchAll(PDO::FETCH_COLUMN);

        return new GroupCollection($this, $groups);
    }
}