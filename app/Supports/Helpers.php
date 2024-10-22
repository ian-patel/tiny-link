<?php

use Illuminate\Support\Str;
use PulkitJalan\GeoIP\GeoIP;
use Illuminate\Encryption\Encrypter;

if (!function_exists('getHost')) {
    /**
     * Get the hostname for the url.
     *
     * @return string
     */
    function getHost(string $url): ? string
    {
        return parse_url($url, PHP_URL_HOST) ?? parse_url($url, PHP_URL_PATH) ?? null;
    }
}

if (!function_exists('uuid')) {
    /**
     * Get the hostname for the url.
     *
     * @return string
     */
    function uuid(): ? string
    {
        return (string)Str::uuid();
    }
}

if (!function_exists('getTitle')) {
    /**
     * Get Link title
     *
     * @return string
     */
    function getTitle($link = null): ? string
    {
        try {
            $data = @file_get_contents($link);
            $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
        } catch (Exception $e) {
            return null;
        }

        return $title;
    }
}

if (!function_exists('getEncrypter')) {
    /**
         * The encrypter implementation
         *
         * @return Illuminate\Encryption\Encrypter;
         */
    function getEncrypter()
    {
        static $encrypter;

        if ($encrypter === null) {
            // If the key starts with "base64:", we will need to decode the key before handing
            // it off to the encrypter. Keys may be base-64 encoded for presentation and we
            // want to make sure to convert them back to the raw bytes before encrypting.
            if (Str::startsWith($key = config('app.key'), 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            $encrypter = new Encrypter($key, config('app.cipher'));
        }

        return $encrypter;
    }
}

if (!function_exists('getGeoIP')) {
    /**
     * Get GeoIP.
     *
     * @return string
     */
    function getGeoIP(): GeoIP
    {
        static $geoip;

        if ($geoip === null) {
            $geoip = new GeoIP();
            $geoip->setIp(
                request()->ip() === '127.0.0.1' ? '47.72.145.231' : request()->ip()
            );
        }

        return $geoip;
    }
}
