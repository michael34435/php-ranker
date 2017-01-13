<?php

namespace PHPRanker\Dry;

use PHPRanker\AbstractParser;

class Parser extends AbstractParser
{

    public function parse()
    {
        return $this->getNodes("duplication", new Violation());
    }
}
