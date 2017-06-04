<?php

namespace ludovicm67\Url\Explorer;

class Explorer {

    private $url;
    private $opts;

    public function __construct($url, $opts = []) {
        $this->url = $url;
        $this->opts = $opts;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getOpts() {
        return $this->opts;
    }

}
