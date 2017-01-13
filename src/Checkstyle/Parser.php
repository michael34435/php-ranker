<?php

namespace PHPRanker\Checkstyle;

use PHPRanker\AbstractParser;

class Parser extends AbstractParser
{

    public function parse()
    {
        return $this->getNodes("file", new Violation());
    }
}
