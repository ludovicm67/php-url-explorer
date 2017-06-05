<?php

namespace ludovicm67\Url\Explorer;

use ludovicm67\Url\Explorer\Parser\DescriptionParser;
use ludovicm67\Url\Explorer\Parser\ImageParser;
use ludovicm67\Url\Explorer\Parser\TitleParser;
use ludovicm67\Url\Explorer\Request\Request;
use ludovicm67\Url\Explorer\Request\RequestBuilder;

class Explorer {

    private $url;
    private $opts;
    private $request;
    private $results = [];

    public function __construct($url, $opts = []) {
        $this->url     = $url;
        $this->opts    = $opts;
        $this->request = Request::fetchAll(new RequestBuilder($url, $opts));
        $this->buildResults();
    }

    private function buildTitle() {
        $title = (new TitleParser($this->request->content))->getResults();
        if (!empty($title)) {
            $this->results["title"] = $title;
        }
    }

    private function buildDescription() {
        $this->results["description"] =
            (new DescriptionParser($this->request->content))->getResults();
    }

    private function buildImage() {
        $this->results["img"] =
            (new ImageParser($this->request->content))->getResults();
    }

    private function buildUrls() {
        $this->results["url"] = [
            "request" => $this->url,
            "final"   => $this->request->infos["url"],
            "base"    => parse_url($this->request->infos["url"])['host']
        ];
    }

    private function buildResults() {
        $this->results["code"] = $this->request->infos["http_code"];
        $this->results["title"] = $this->request->infos["url"];
        if ($this->request->empty) {
            $this->results["description"] = "";
            $this->results["img"] = null;
        } else {
            $this->buildTitle();
            $this->buildDescription();
            $this->buildImage();
        }
        $this->buildUrls();
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

    public function getResults() {
        return (object) $this->results;
    }

    public function json() {
        return json_encode($this->results,
            JSON_PRETTY_PRINT
            | JSON_UNESCAPED_SLASHES
            | JSON_UNESCAPED_UNICODE);
    }

    public function __toString() {
        return $this->json();
    }

}
