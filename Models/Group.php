<?php


class Group
{
    public static function addGroup($groupName)
    {
        QueryBuilder::getInstance()
            ->table("groups")
            ->insert(["group_name" => $groupName]);
    }

    public static function removegroup($groupID)
    {
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
}