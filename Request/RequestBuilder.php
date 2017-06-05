<?php

namespace ludovicm67\Url\Explorer\Request;

class RequestBuilder {

    // request params that can be changed
    public $url;
    public $followlocation = true;
    public $encoding       = "";
    public $useragent      = "spider";
    public $autoreferer    = true;
    public $connecttimeout = 120;
    public $timeout        = 120;
    public $maxredirs      = 10;
    public $post           = false;
    public $postfields;
    public $ssl_verifyhost = 0;
    public $ssl_verifypeer = false;

    public function __construct($url = "", $opts = []) {
        $this->url = $url;

        if (!empty($opts)) {
            $this->followlocation = $this->parseOpts($opts, "followlocation");
            $this->encoding       = $this->parseOpts($opts, "encoding");
            $this->useragent      = $this->parseOpts($opts, "useragent");
            $this->autoreferer    = $this->parseOpts($opts, "autoreferer");
            $this->connecttimeout = $this->parseOpts($opts, "connecttimeout");
            $this->timeout        = $this->parseOpts($opts, "timeout");
            $this->maxredirs      = $this->parseOpts($opts, "maxredirs");
            $this->post           = $this->parseOpts($opts, "post");
            $this->postfields     = $this->parseOpts($opts, "postfields");
            $this->ssl_verifyhost = $this->parseOpts($opts, "ssl_verifyhost");
            $this->ssl_verifypeer = $this->parseOpts($opts, "ssl_verifypeer");
        }
    }

    private function parseOpts($arr, $key) {
        if (isset($arr["$key"])) {
            return $arr["$key"];
        } else {
            return $this->{$key};
        }
    }

    public function url($url) {
        $this->url = $url;
        return $this;
    }

    public function followlocation() {
        $this->followlocation = true;
        return $this;
    }

    public function encoding($encoding = "") {
        $this->encoding = $encoding;
        return $this;
    }

    public function useragent($useragent) {
        $this->useragent = useragent;
        return $this;
    }

    public function autoreferer() {
        $this->autoreferer = true;
        return $this;
    }

    public function noAutoreferer() {
        $this->autoreferer = false;
        return $this;
    }

    public function connecttimeout($time) {
        $this->connecttimeout = $time;
        return $this;
    }

    public function timeout($time) {
        $this->timeout = $time;
        return $this;
    }

    public function maxredirs($max) {
        $this->maxredirs = $max;
        return $this;
    }

    public function verifySSL() {
        $this->ssl_verifyhost = 2;
        $this->ssl_verifypeer = true;
        return $this;
    }

    public function post($datas) {
        $this->post = true;
        $this->postfields = $datas;
        return $this;
    }

    public function getCurlOpts() {
        return [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => $this->followlocation,
            CURLOPT_ENCODING       => $this->encoding,
            CURLOPT_USERAGENT      => $this->useragent,
            CURLOPT_AUTOREFERER    => $this->autoreferer,
            CURLOPT_CONNECTTIMEOUT => $this->connecttimeout,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_MAXREDIRS      => $this->maxredirs,
            CURLOPT_POST           => $this->post,
            CURLOPT_POSTFIELDS     => $this->postfields,
            CURLOPT_SSL_VERIFYHOST => $this->ssl_verifyhost,
            CURLOPT_SSL_VERIFYPEER => $this->ssl_verifypeer
        ];
    }
}
