<?php

namespace NFePHP\Ibge;

class Rest
{
    /**
     * Send request for IBGE REST service
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public static function send($url)
    {
        $oCurl = curl_init($url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($oCurl);
        $info = curl_getinfo($oCurl);
        curl_close($oCurl);
        if ($info['http_code'] !== 200) {
            throw new \Exception('Erro cURL: ' . var_export($info));
        }
        return $response;
    }
}
