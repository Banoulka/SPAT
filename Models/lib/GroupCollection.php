<?php


class GroupCollection
{
    private $user;
    private $teams = [];

    public function __construct(User $user, array $teams)
    {
        $this->user = $user;
        $this->teams = $teams;
    }

    public function list()
    {
        return $this->teams;
    }

    public function listIDs()
    {
        return array_map(function($item) {
            return $item->id;
        }, $this->teams);
    }

    public function setTeam($teamIDArr)
    {
        // Remove all the groups previously
        QueryBuilder::getInstance()
            ->table("team_members")
            ->remove([
                "user_id" => $this->user->id()
            ]);

        // Add each group to the database
        foreach ($teamIDArr as $teamID)
        {

            QueryBuilder::getInstance()
                ->table("team_members")
                ->insert([
                    "user_id" => $this->user->id(),
                    "team_id" => $teamID
                ]);
        }
    }

    public function addTeam($teamID)
    {
        QueryBuilder::getInstance()
            ->table("team_members")
            ->insert([
                "user_id" => $this->user->id(),
                "team_id" => $teamID
            ]);
    }

    public function removeTeam($teamID)
    {
        QueryBuilder::getInstance()
            ->table("team_members")
            ->remove([
                "user_id" => $this->user->id(),
                "team_id" => $teamID
            ]);
    }
}