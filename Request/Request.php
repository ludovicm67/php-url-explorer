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

        $ch = curl_init($request->url);
        curl_setopt_array($ch, $request->getCurlOpts());
        $this->content = curl_exec($ch);
        if ($this->content === false) {
            $this->content = "";
        } else {
            $this->empty = false;
        }
        $this->infos   = curl_getinfo($ch);
        curl_close($ch);
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
