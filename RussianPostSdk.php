<?php

namespace Sdk;

use Exception;


class RussianPostSdk
{
    static private $apiKey;

    static private $password;

    static private $url;

    /**
     * Sets api url, apiKey and password
     * @param $url
     * @param $api_key
     * @param $password
     * @throws Exception
     */
    static public function init($url, $api_key, $password=null)
    {
        if(is_string($api_key) && is_string($password) && is_string($url)){
            self::$apiKey = $api_key;
            self::$password = $password;
            self::$url = $url;
        } else {
            throw new Exception('URL, apiKey and password might be a string!');
        }

    }

    static public function calc($from_index, $to_index, $weight, $ob_cennost_rub)
    {
        $params = [
            "from_index"=>$from_index,
            "to_index"=>$to_index,
            "weight"=>$weight,
            "ob_cennost_rub"=>$ob_cennost_rub
        ];
        return self::call(__FUNCTION__,$params);
    }

    static private function call($method , $params)
    {
        if(!extension_loaded('curl')){
            throw new Exception('You have to enable curl extension!');
        }

        if(empty(self::$apiKey) || empty(self::$url)){
            throw new Exception('apiKey and url can not be blank! Use init() method.');
        }

        $params["apikey"] = self::$apiKey;
        $params["method"] = $method;

        if (!empty(self::$password)) {
            //если пароль указан, аутентификация по методу API ключ + API пароль.
            $all_to_md5 = $params;
            $all_to_md5[] = self::$password;
            $hash = md5(implode("|", $all_to_md5));
            $params["hash"] = $hash;
        }

        try{
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::$url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);

            curl_close($curl);

            if($response === false) {
                throw new Exception("10000 server error");
            }

            $data = json_decode($response, $assoc=true);

            if (isset($data['msg']['type']) && $data['msg']['type'] == "error") {
//                throw new Exception(print_r($data, true));
                throw new Exception($data['msg']['text']);
            }

            return $data;
        } catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

    }

}