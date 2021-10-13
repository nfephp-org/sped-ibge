<?php

/**
 * This file belongs to the NFePHP project
 * php version 7.0 or higher
 *
 * @category  Library
 * @package   NFePHP\Ibge
 * @author    Roberto L. Machado <liuux.rlm@gmail.com>
 * @copyright 2021 NFePHP Copyright (c) 
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibge
 */

namespace NFePHP\Ibge;

/**
 * Class RestAPI client
 * 
 * @category  Library
 * @package   NFePHP\Ibge
 * @author    Roberto L. Machado <liuux.rlm@gmail.com>
 * @copyright 2021 NFePHP Copyright (c) 
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      http://github.com/nfephp-org/sped-ibge
 */
class Rest
{
    /**
     * Send request for IBGE REST service
     *
     * @param string $url url do IBGE
     * 
     * @return string
     * 
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
