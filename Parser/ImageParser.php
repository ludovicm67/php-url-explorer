<?php

namespace ludovicm67\Url\Explorer\Parser;

use ludovicm67\Url\Explorer\Parser\Parser;

class ImageParser extends Parser {

    public function __construct($data = "") {
        parent::__construct($data);

        $doc = new \DomDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($data);
        libxml_clear_errors();
        $xp = new \DOMXPath($doc);

        foreach ($xp->query("//meta[@property='og:image']") as $el) {
            $this->results = $this->cleanString($el->getAttribute("content"));
        }

        if (empty($this->results)) {
            foreach ($xp->query("//meta[@property='twitter:image:src']") as $el) {
                $this->results = $this->cleanString($el->getAttribute("content"));
            }
        }

        if (empty($this->results)) {
            $img = $xp->query('//img');
            if ($img->length > 0) {
                $this->results = $this->cleanString($img->item(0)->getAttribute("src"));
            }
        }

    }

}
