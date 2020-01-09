<?php


class Group
{
    public static function addTeam($teamName)
    {
        QueryBuilder::getInstance()
            ->table("teams")
            ->insert(["team_name" => $teamName]);
    }

    public static function removeTeam($teamID)
    {
        QueryBuilder::getInstance()
            ->table("teams")
            ->remove(["id" => $teamID]);
    }

    public static function allTeams()
    {
        return QueryBuilder::getInstance()
            ->table("teams")
            ->fetchAs("Group")
            ->orderby("team_name")
            ->getAll();
    }
}