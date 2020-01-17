<?php


class Group
{
    public function updateGroup($groupName)
    {
        $sql = "UPDATE `groups` SET group_name = :groupName WHERE id = $this->id";
        $stmt = Database::db()->prepare($sql);
        $stmt->bindParam(":groupName", $groupName);
        $stmt->execute();
    }

    public static function addGroup($groupName)
    {
        QueryBuilder::getInstance()
            ->table("groups")
            ->insert(["group_name" => $groupName]);
    }

    public static function removegroup($groupID)
    {
        QueryBuilder::getInstance()
            ->table("group_members")
            ->remove(["group_id" => $groupID]);

        QueryBuilder::getInstance()
            ->table("groups")
            ->remove(["id" => $groupID]);
    }

    public static function allgroups()
    {
        return QueryBuilder::getInstance()
            ->table("groups")
            ->fetchAs("Group")
            ->orderby("group_name")
            ->getAll();
    }

    /**
     * @param $id
     * @return Group
     */
    public static function groupByID($id)
    {
        return QueryBuilder::getInstance()
            ->table("groups")
            ->fetchAs("Group")
            ->where("id", $id)
            ->first();
    }

    public static function groupIDsbyUserID($id)
    {
        $sql = "SELECT group_id FROM group_members WHERE user_id = $id";
        $stmt = Database::db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}