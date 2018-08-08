<?php

namespace ludovicm67\Url\Explorer\Parser;

use ludovicm67\Url\Explorer\Parser\Parser;

class DescriptionParser extends Parser {

    public function __construct($data = "") {
        parent::__construct($data);

        $doc = new \DomDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($data);
        libxml_clear_errors();
        $xp = new \DOMXPath($doc);

        foreach ($xp->query("//meta[@property='og:description']") as $el) {
            $this->results = $this->cleanString($el->getAttribute("content"));
            if (!empty($this->results)) break;
        }

        if (empty($this->results)) {
            foreach ($xp->query("//meta[@name='description']") as $el) {
                $this->results = $this->cleanString($el->getAttribute("content"));
                if (!empty($this->results)) break;
            }
        }

        if (empty($this->results)) {
            foreach ($xp->query("//meta[@name='Description']") as $el) {
                $this->results = $this->cleanString($el->getAttribute("content"));
                if (!empty($this->results)) break;
            }
        }

        if (empty($this->results)) {
            foreach ($xp->query("//meta[@name='DESCRIPTION']") as $el) {
                $this->results = $this->cleanString($el->getAttribute("content"));
                if (!empty($this->results)) break;
            }
        }

        if (empty($this->results)) {
            $data = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $data);
            $data = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $data);
            $data = preg_replace('#<a(.*?)>(.*?)</a>#is', '', $data);
            $data = preg_replace('#<ul(.*?)>(.*?)</ul>#is', '', $data);
            $data = preg_replace('#<ol(.*?)>(.*?)</ol>#is', '', $data);
            $data = trim($data);
            $this->results = mb_strimwidth(
                $this->cleanString($data), 0, 500, "..."
            );
        }

    }

}
