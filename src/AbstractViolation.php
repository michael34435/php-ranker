<?php

namespace PHPRanker;

abstract class AbstractViolation
{

    protected $remediation;

    public function getRemediationPoints()
    {
        return $this->remediation;
    }

    abstract public function add(array $nodes);
}
