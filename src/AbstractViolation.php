<?php

namespace PHPRanker;

abstract class AbstractViolation
{

    protected $remediation;

    public function getRemediationPoints()
    {
        return $this->remediation ?: 0;
    }

    abstract public function add(array $nodes);
}
