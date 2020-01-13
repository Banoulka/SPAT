<?php


class API
{

//    Buildings
    public static function getAllBuildings()
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/buildings");

        return $res->buildings;
    }

    public static function getBuildingByID($id)
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/buildings/$id");
        return $res->building;
    }

    public static function createBuilding($dataArr)
    {
        $payload = json_encode($dataArr);
        $options = [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
        ];

        $res = self::setupCurl("http://3.11.87.121/api/v1/buildings", $options);

        return $res->building;
    }

    public static function deleteBuilding($id)
    {
        $options = [
          CURLOPT_CUSTOMREQUEST => "DELETE",
        ];
        $res = self::setupCurl("http://3.11.87.121/api/v1/buildings/$id", $options);
        return $res->building;
    }

    //Infrastructure;

    public static function getAllInfrastructure()
    {
       $res = self::setupCurl("http://3.11.87.121/api/v1/infrastructure");
       return $res->infrastructure;
    }

    public static function getInfrastructureByID($id)
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/buildings/$id");
        return $res->infrastructure;
    }

    public static function createInfrastructure($dataArr)
    {
        $payload = json_encode($dataArr);
        $options = [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array("Content-Type:application/json")
        ];

        $res = self::setupCurl("http://3.11.87.121/api/v1/infrastructure" ,$options);

        $res->infrastructure;

    }

    public static function deleteInfrastructure($id)
    {
        $options = [
            CURLOPT_CUSTOMREQUEST => "DELETE",

        ];
        $res = self::setupCurl("http://3.11.87.121/api/v1/infrastructure/$id", $options);
        return $res->infrastructure;
    }

    //demographics
    public static function getAllDemographics()
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/demographics");
        return $res->demographics;
    }

    public static function getDemographicsById($id)
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/demographics/$id");
        return $res->demographics;
    }

    public static function createDemographics($dataArr)
    {
        $payload = json_encode($dataArr);
        $options = [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
        ];

        $res = self::setupCurl("http://3.11.87.121/api/v1/demographics", $options);

        return $res->demographics;
    }

    public static  function  deleteDemographics($id)
    {
        $options = [
            CURLOPT_CUSTOMREQUEST => "DELETE",
        ];
        $res = self::setupCurl("http://3.11.87.121/api/v1/demographics/$id", $options);
        return $res->demographics;
    }

    //utilities;
    public static function getAllUtilities()
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/utilities");

        return $res->utilities;
    }

    public static function getUtilitiesByID($id)
    {
        $res = self::setupCurl("http://3.11.87.121/api/v1/utilities/$id");
        return $res->utilities;
    }

    public static function createUtilities($dataArr)
    {
        $payload = json_encode($dataArr);
        $options = [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array("Content-Type:application/json"),
        ];

        $res = self::setupCurl("http://3.11.87.121/api/v1/utilities", $options);

        return $res->utilities;

    }

    public static function deleteUtilities($id)
    {
        $options = [
            CURLOPT_CUSTOMREQUEST => "DELETE",
            ];
        $res = self::setupCurl("http://3.11.87.121/api/v1/utilities/$id", $options);
        return $res->utilities;
    }

    /**
     * @param $url
     * @param array $opt
     * @return mixed
     */
    private static function setupCurl($url, $opt = [])
    {
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HEADER, false);

       if (!empty($opt)) {
           curl_setopt_array($curl, $opt);
       }

        $response = curl_exec($curl);
        return json_decode($response);
    }
}