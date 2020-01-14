<?php

/**
 * Class SessionLog
 * @property string endpoint
 * @property boolean succeeded
 * @property int id
 * @property string timestamp
 * @property User user
 */
class SessionLog
{
    public function __construct()
    {
        $this->user = User::findByID($this->user_id);
        unset($this->user_id);
    }

    public static function createLog($dataArr)
    {
        $dataArr["user_id"] = Authentication::User()->id();
        QueryBuilder::getInstance()
            ->table("SessionLog")
            ->insert($dataArr);
    }

    public static function getAllLogs()
    {
        return QueryBuilder::getInstance()
            ->table("SessionLog")
            ->fetchAs("SessionLog")
            ->orderby("timestamp")
            ->getAll();
    }
}