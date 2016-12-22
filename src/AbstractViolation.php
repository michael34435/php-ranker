<?php

namespace PHPRanker;

abstract class AbstractViolation
{

    protected $remediation;

    public function getRemediationPoints()
    {
        return $this->remediation;
    }

    abstract public function addViolation(array $nodes);
}
