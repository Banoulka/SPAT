<?php


class Role
{
    private $permissions;

    public function __construct()
    {
        if (!is_null($this->permissions)) {
            $permArray = explode(",", (string)$this->permissions);
            $this->permissions = $permArray;
        }
    }

    public function hasPermission($permission)
    {
        return is_null($this->permissions) ? false : in_array($permission, $this->permissions);
    }

    public function addPermission($permission)
    {
        if (!$this->hasPermission($permission)) {
            if (is_null($this->permissions)) {
                $permissions = $permission;
            } else {
                array_push($this->permissions, $permission);
                $permissions = implode(",", $this->permissions);
            }

            $sql = "UPDATE roles SET permissions = \"$permissions\"
                    WHERE id = $this->id";
            Database::db()->query($sql);
        }
    }

    public function removePermission($permission)
    {
        if ($this->hasPermission($permission)) {
            $index = array_search($permission, $this->permissions);
            unset($this->permissions[$index]);
            $permissions = empty($this->permissions) ? null : implode(",", $this->permissions) ;
            if (is_null($permissions)) {
                $sql = "UPDATE roles SET permissions = null
                    WHERE id = $this->id";
            } else {
                $sql = "UPDATE roles SET permissions = \"$permissions\"
                    WHERE id = $this->id";
            }
            Database::db()->query($sql);
        }
    }

    /**
     * @param $roleID
     *
     * @return Role
     */
    public static function getRole($roleID)
    {
        return QueryBuilder::getInstance()
            ->table("roles")
            ->where("id", $roleID)
            ->fetchAs("Role")
            ->first();
    }

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
            ->table("user_roles")
            ->remove(["role_id" => $roleID]);

        QueryBuilder::getInstance()
            ->table("roles")
            ->remove(["id" => $roleID]);
    }

    /**
     * @return Role[]
     */
    public static function allRoles()
    {
        return QueryBuilder::getInstance()->table("roles")
                ->fetchAs("Role")
                ->orderby("role_name")
                ->getAll();
    }
}