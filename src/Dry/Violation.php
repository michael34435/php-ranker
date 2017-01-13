<?php

namespace PHPRanker\Dry;

use PHPRanker\AbstractViolation;

class Violation extends AbstractViolation
{

    private $defaultMass = 28;
    private $overage     = 100000;
    private $base        = 1500000;

    public function add(array $nodes)
    {
        isset($nodes["tokens"]) ?: $nodes["tokens"] = 0;

        $points = (int) $nodes["tokens"];

        if ($points >= $this->defaultMass) {
            $points -= $this->defaultMass;
            $this->remediation = $this->base + ($points * $this->overage);
        }

        return $this;
    }
}
