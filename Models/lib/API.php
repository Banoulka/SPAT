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

    //TODO: Add infrastructure
    //TODO: Add Demographics
    //TODO: Add Utilities


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