<?php


class SessionLog
{
    public static function createLog($dataArr)
    {
        $dataArr["user_id"] = Authentication::User()->id();
        QueryBuilder::getInstance()
            ->table("SessionLog")
            ->insert($dataArr);
    }
}