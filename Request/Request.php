<?php

namespace ludovicm67\Url\Explorer\Request;

use ludovicm67\Url\Explorer\Exception\SupportException;
use ludovicm67\Url\Explorer\Exception\TypeException;

class Request {

    public static function getContent(RequestBuilder $request) {
        if (!filter_var($request->url, FILTER_VALIDATE_URL)) {
            throw new TypeException("Only content from a valid URL can be fetched");
        }

        if (!function_exists('curl_version')) {
            throw new SupportException("Curl is not supported on your configuration.");
        }

        $ch = curl_init($request->url);
        curl_setopt_array($ch, $request->getCurlOpts());
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

}
