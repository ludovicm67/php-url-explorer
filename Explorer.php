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
        if (substr($this->request->infos["content_type"], 0, strlen("text/")) === "text/") {
            $this->results["description"] =
                (new DescriptionParser($this->request->content))->getResults();
        }
    }

    private function buildImage() {
        $img = (new ImageParser($this->request->content))->getResults();

        if (!$img && substr($this->request->infos["content_type"], 0, strlen("image/")) === "image/") {
            $this->results["type"] = "image";
            $img = $this->request->infos["url"];
            $this->request->content = "";
        }

        $img_size = @getimagesize($img);
        if (is_array($img_size)) {
            $this->results["img"] = [
                "url"    => $img,
                "width"  => $img_size[0],
                "height" => $img_size[1],
                "mime"   => $img_size["mime"]
            ];
        } else {
            $this->results["img"] = null;
            unset($this->results["type"]);
        }

    }

    private function buildType() {
        if (isset($this->results["type"])) {
            return;
        }
        if ($this->request->empty) {
            $this->results["type"] = "none";
        } else if (!$this->results["img"]) {
            $this->results["type"] = "basic";
        } else if ($this->results["img"]["width"] >= 450
            && $this->results["img"]["height"] >= 200) {
            $this->results["type"] = "large";
        } else {
            $this->results["type"] = "small";
        }
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
        $this->results["description"] = "";
        $this->results["img"] = null;
        if (!$this->request->empty) {
            $this->buildTitle();
            $this->buildDescription();
            $this->buildImage();
        }
        $this->buildType();
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
