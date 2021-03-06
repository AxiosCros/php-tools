<?php

declare(strict_types=1);

use axios\tools\HMac;

if (!function_exists('hmac')) {
    function hmac(string $algorithm, string $data = '', string $secret = '', bool $raw_output = false): string
    {
        $hamc = new HMac();
        $res  = $hamc->count($algorithm, $data, $secret, $raw_output);
        unset($hamc);

        return $res;
    }
}

if (!function_exists('halt') && function_exists('dump')) {
    function halt(...$args)
    {
        dump(...$args);

        exit();
    }
}

if (!function_exists('sm3')) {
    function sm3(string $str, bool $raw_output = false): string
    {
        $sm3 = new \axios\tools\SM3();
        $sm3->encode($str);

        return $raw_output ? $sm3->getBinary() : $sm3->getHex();
    }
}

if (!function_exists('sm3_file')) {
    function sm3_file(string $filepath, bool $raw_output = false): string
    {
        $sm3 = new \axios\tools\SM3();
        $sm3->encodeFile($filepath);

        return $raw_output ? $sm3->getBinary() : $sm3->getHex();
    }
}

if (!function_exists('xml_encode')) {
    function xml_encode(array $data, $root_node = 'data', $root_attr = [], $item_node = 'item', $item_key = 'id', $encoding = 'utf-8'): string
    {
        return \axios\tools\XMLParser::encode($data, $root_node, $root_attr, $item_node, $item_key, $encoding);
    }
}

if (!function_exists('xml_decode')) {
    function xml_decode(string $xml_string): array
    {
        return \axios\tools\XMLParser::decode($xml_string);
    }
}

if (!function_exists('uuid')) {
    function uuid(string $salt = ''): string
    {
        $uuid = new \axios\tools\UUID($salt);
        $str  = $uuid->v2();
        unset($uuid);

        return $str;
    }
}

if (!function_exists('path_join')) {
    function path_join(string ...$paths): string
    {
        return \axios\tools\Path::join(...$paths);
    }
}

if (!function_exists('client_ip')) {
    /*
     * get the IP address of the client
     *
     * @param int  $type 0 => return IP string; 1=> return IP number
     * @param bool $adv  advance mode
     *
     * @return mixed
     */
    function client_ip(int $type = 0, bool $advance = false)
    {
        $type      = $type ? 1 : 0;
        static $ip = null;
        if (null !== $ip) {
            return $ip[$type];
        }
        if ($advance) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP address legitimacy verification
        $long = sprintf('%u', ip2long($ip));
        $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];

        return $ip[$type];
    }
}
