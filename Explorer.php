<?php

namespace ludovicm67\Url\Explorer;

use ludovicm67\Url\Explorer\Request\Request;
use ludovicm67\Url\Explorer\Request\RequestBuilder;

class Explorer {

    private $url;
    private $opts;
    private $request;

    public function __construct($url, $opts = []) {
        $this->url     = $url;
        $this->opts    = $opts;
        $this->request = Request::fetchAll(new RequestBuilder($url, $opts));
    }

    public function getUrl() {
        return $this->url;
    }

    public function getOpts() {
        return $this->opts;
    }

    public function getRequest() {
        return $this->request;
    }

}
