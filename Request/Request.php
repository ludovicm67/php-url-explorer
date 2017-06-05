<?php

namespace ludovicm67\Url\Explorer\Request;

use ludovicm67\Url\Explorer\Exception\SupportException;
use ludovicm67\Url\Explorer\Exception\TypeException;

class Request {

    public $content;
    public $infos;
    public $empty = true;

    public function __construct(RequestBuilder $request) {
        if (!filter_var($request->url, FILTER_VALIDATE_URL)) {
            throw new TypeException("Only content from a valid URL can be fetched");
        }

        if (!function_exists('curl_version')) {
            throw new SupportException("Curl is not supported on your configuration.");
        }

        $this->runRequest($request);
    }

    private function runRequest(RequestBuilder $request) {
        $ch = curl_init($request->url);
        curl_setopt_array($ch, $request->getCurlOpts());
        $this->content = curl_exec($ch);
        if ($this->content === false) {
            $this->content = "";
        } else {
            $this->empty = false;
        }
        $this->infos = curl_getinfo($ch);
        curl_close($ch);

        $code = $this->infos["http_code"];
        if ($code >= 400 && $code < 500 && ini_get('allow_url_fopen')) {
            $this->content = file_get_contents($this->infos["url"]);
            preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $http_response_header[0], $out);
            $this->infos["http_code"] = intval($out[1]);
        }
    }

    public function getContent() {
        return $this->content;
    }

    public function getInfos() {
        return $this->infos;
    }

    public static function fetch(RequestBuilder $request) {
        $req = new Request($request);
        return $req->getContent();
    }

    public static function fetchContent(RequestBuilder $request) {
        return self::fetch($request);
    }

    public static function fetchAll(RequestBuilder $request) {
        $req = new Request($request);
        return $req;
    }

}
