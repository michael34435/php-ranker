<?php

namespace PHPRanker\Dry;

use PHPRanker\AbstractViolation;
use DrSlump\Sexp;

class Violation extends AbstractViolation
{

    public function addViolation(array $nodes)
    {
        $code = $nodes["sourceCode"];
        // $parser = (new PhpParser\ParserFactory())->create(PhpParser\ParserFactory::PREFER_PHP7);
        return $this;
    }
}
