<?php

namespace ludovicm67\Url\Explorer\Parser;

use ludovicm67\Url\Explorer\Exception\DataException;
use ludovicm67\Url\Explorer\Exception\TypeException;

abstract class Parser {

    protected $datas;
    protected $results;

    public function __construct($datas = "") {
        if (!is_string($datas)) {
            throw new TypeException("The parser can only parse a string!");
        } else if ($datas === "") {
            throw new DataException("Nothing to parse!");
        }
        $this->datas = $datas;
    }

    public function getDatas() {
        return $this->datas;
    }

    public function getResults() {
        return $this->results;
    }

    protected function cleanString($str) {
        return preg_replace('!\s+!', ' ', trim(strip_tags(html_entity_decode($str))));
    }

}
