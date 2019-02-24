<?php

if (! function_exists('getHost')) {
    /**
     * Get the hostname for the url.
     *
     * @return string
     */
    function getHost(string $url): ?string
    {
        return parse_url($url, PHP_URL_HOST) ?? parse_url($url, PHP_URL_PATH) ?? null;
    }
}
