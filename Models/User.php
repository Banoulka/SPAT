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
        $hashedPass = password_hash($dataArray["password"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO admin_requests (username, password, email) VALUES (:username, :password, :email)";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":username", $dataArray["username"]);
        $stmt->bindParam(":email", $dataArray["email"]);
        $stmt->bindParam(":password", $hashedPass);
        $stmt->execute();
    }

    public function remove()
    {
        QueryBuilder::getInstance()
            ->table("user_roles")
            ->remove(["user_id" => $this->id]);

        QueryBuilder::getInstance()
            ->table("group_members")
            ->remove(["user_id" => $this->id]);

        QueryBuilder::getInstance()
            ->table("users")
            ->remove(["id" => $this->id]);
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
     * @param $id
     *
     * @return User
     */
    public static function findByID($id)
    {
        $foundUser = QueryBuilder::getInstance()
            ->table("users")
            ->where("id", $id)
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

    /**
     * @param $username
     * @return User
     */
    public static function getUserRequestByUsername($username)
    {
        return QueryBuilder::getInstance()
            ->table("admin_requests")
            ->where("username", $username)
            ->fetchAs("User")
            ->first();
    }

    /**
     * @return User[]
     */
    public static function getAllAdminRequests()
    {
        return QueryBuilder::getInstance()
            ->table("admin_requests")
            ->fetchAs("User")
            ->orderby("timestamp")
            ->getAll();
    }

    // Relationships

    /**
     * @return Role
     */
    public function role()
    {
        $sql = "SELECT id, role_name, editable, permissions FROM user_roles
                LEFT JOIN roles r on user_roles.role_id = r.id
                WHERE user_id = $this->id";
        $stmt = Database::db()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Role");
        $stmt->execute();
        if (!$stmt->fetch()) {
            $sql = "INSERT INTO user_roles VALUES ($this->id, 4)";
            Database::db()->exec($sql);
        }
        $stmt->execute();

        return $stmt->fetch();
    }

    public function isRole($roleName)
    {
        $role = $this->role()->role_name;
        return $role === $roleName;
    }

    public function isAdmin()
    {
        return $this->isRole("Admin");
    }

    public function teams()
    {
        $sql = "SELECT group_name, id FROM group_members
                LEFT JOIN `groups` t on group_members.group_id = t.id
                WHERE user_id = $this->id";

        $groups = Database::db()->query($sql)->fetchAll(PDO::FETCH_OBJ);

        return new GroupCollection($this, $groups);
    }

    public function updateDetails($dataArr)
    {
        $username = $dataArr["username"];
        $userID = $dataArr["userID"];
        $roleID = $dataArr["roleID"];
        $groupIDS = explode(",", $dataArr["groupIDs"]);

        // Update username
        $sql = "UPDATE users SET username = \"$username\" WHERE id = $userID";
        Database::db()->exec($sql);

        // Update Role
        $sql = "UPDATE user_roles SET role_id = $roleID WHERE user_id = $userID";
        Database::db()->exec($sql);

        // Update Groups
        $sql = "DELETE FROM group_members WHERE user_id = $userID";
        Database::db()->exec($sql);

        $sql = "";
        if (!empty($groupIDS) && !empty($groupIDS[0])) {
            foreach ($groupIDS as $id) {
                $sql .= "INSERT INTO group_members VALUES ($userID, $id);";
            }
            Database::db()->exec($sql);
        }
    }
}