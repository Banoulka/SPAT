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
            ->getAll();
    }

    public static function getJSONLogs()
    {
        $sql = "SELECT SessionLog.id, u.username, endpoint, succeeded, timestamp, reason
                FROM SessionLog LEFT JOIN users u on SessionLog.user_id = u.id";

        $stmt = Database::db()->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}