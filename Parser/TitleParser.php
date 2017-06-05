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
            $this->results = $this->cleanString($el->getAttribute("content"));
        }

        if (empty($this->results)) {
            $title = $xp->query('//title');
            if ($title->length > 0) {
                $this->results = $this->cleanString($title->item(0)->textContent);
            }
        }

    }

}
