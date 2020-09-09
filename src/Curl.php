<?php
namespace Yapf;

class Curl
{
    static function get(string $url): object
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($ret);
        return $data;
    }

    static function post(string $url, array $data, $assoc = false): object
    {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);
        $data = null;
        if ($assoc) {
            $data = new \stdClass();
            $data->data = $ret;
        } else {
            $data = json_decode($ret);
        }
        return $data;
    }
}