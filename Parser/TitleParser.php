<?php

namespace ludovicm67\Url\Explorer\Parser;

use ludovicm67\Url\Explorer\Parser\Parser;

class TitleParser extends Parser {

    public function __construct($data = "") {
        parent::__construct($data);

        $doc = new \DomDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($data);
        libxml_clear_errors();
        $xp = new \DOMXPath($doc);

        foreach ($xp->query("//meta[@property='og:title']") as $el) {
            $this->results = $el->getAttribute("content");
        }

        if (empty($this->results)){
            if (preg_match('#<title[^>]*>(.+)<\/title>#', $data, $title)) {
                $this->results = $title[1];
            }
        }

    }

}
