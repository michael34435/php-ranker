<?php

namespace PHPRanker\Dry;

use PHPRanker\AbstractViolation;

class Violation extends AbstractViolation
{

    private $defaultMass = 28;
    private $overage     = 100000;
    private $base        = 1500000;
    private $semicolon   = ["{", "}"];
    private $operator    = ["+=", "-=", "*=", "/=", "++", "--", ".="];

    public function addViolation(array $nodes)
    {
        $code   = $nodes["sourceCode"];
        $tokens = token_get_all("<?php {$code}");
        $points = 0;
        foreach ($tokens as $token) {
            if (is_array($token)) {
                $token = $token[1];
            }

            $token = trim($token);

            if ($token) {
                $points ++;
            }

            if (in_array($token, $this->semicolon)) {
                $points ++;
            }

            if (in_array($token, $this->operator)) {
                $points ++;
            }
        }

        if ($points > $this->defaultMass) {
            $points -= $this->defaultMass;
            $this->remediation = $this->base + ($points * $this->overage);
        }

        return $this;
    }
}
