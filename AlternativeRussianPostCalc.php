<?php

namespace Sdk;

use Exception;

/**
 * Альтернативный калькулятор на базе бесплатного сервиса http://print-post.com/api_raschet_stoimosti_otpravleniya.htm
 * Class AlternativeRussianPostCalc
 * @package Sdk
 */
class AlternativeRussianPostCalc
{
    /**
     * @param $from_index
     * @param $to_index
     * @param $weight
     * @param $ob_cennost_rub
     * @return mixed
     * @throws Exception
     */
    public static function alternativeCalc($from_index, $to_index, $weight, $ob_cennost_rub)
    {
        $url  = 'http://api.print-post.com/api/sendprice/v2/?weight=' . $weight . '&summ='. $ob_cennost_rub . '&from_index=' . $from_index . '&to_index=' . $to_index;

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);

            $data = json_decode($out, true);
            curl_close($curl);

            return $data;
        } catch(Exception $e){
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

}