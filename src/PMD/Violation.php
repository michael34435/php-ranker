<?php

namespace PHPRanker\PMD;

use ReflectionClass;
use PHPMD\RuleSetFactory;
use PHPRanker\AbstractViolation;

class Violation extends AbstractViolation
{

    private $checks = [
        "BooleanArgumentFlag"                 => 300000,
        "ElseExpression"                      => 200000,
        "StaticAccess"                        => 200000,
        "CamelCaseClassName"                  => 500000,
        "CamelCaseMethodName"                 => 1000,
        "CamelCaseParameterName"              => 500000,
        "CamelCasePropertyName"               => 500000,
        "CamelCaseVariableName"               => 25000,
        "Superglobals"                        => 100000,
        "CyclomaticComplexity"                => 100000,
        "CouplingBetweenObjects"              => 400000,
        "DepthOfInheritance"                  => 500000,
        "DevelopmentCodeFragment"             => 100000,
        "EvalExpression"                      => 300000,
        "ExitExpression"                      => 200000,
        "GotoStatement"                       => 200000,
        "LongClass"                           => 200000,
        "LongMethod"                          => 200000,
        "LongParameterList"                   => 200000,
        "NpathComplexity"                     => 200000,
        "NumberOfChildren"                    => 1000000,
        "TooManyFields"                       => 900000,
        "TooManyMethods"                      => 2000000,
        "TooManyPublicMethods"                => 2000000,
        "WeightedMethodCount"                 => 2000000,
        "ExcessivePublicCount"                => 700000,
        "BooleanGetMethodName"                => 200000,
        "ConstantNamingConventions"           => 100000,
        "ConstructorWithNameAsEnclosingClass" => 400000,
        "LongVariable"                        => 1000000,
        "ShortMethodName"                     => 800000,
        "ShortVariable"                       => 500000,
        "UnusedFormalParameter"               => 200000,
        "UnusedLocalVariable"                 => 200000,
        "UnusedPrivateField"                  => 200000,
        "UnusedPrivateMethod"                 => 200000,
    ];

    public function add(array $nodes)
    {
        isset($nodes["type"]) ?: $nodes["type"] = "";

        $type = $nodes["type"];
        $name = $this->getRule($type);

        isset($this->checks[$name]) ?: $this->checks[$name] = 0;

        $this->remediation = $this->checks[$name];

        return $this;
    }

    private function getRule($type)
    {
        $ruleset  = new RuleSetFactory();
        $rulesets = $ruleset->listAvailableRuleSets();
        foreach ($rulesets as $set) {
            $rule = $ruleset->createSingleRuleSet($set)->getRuleByName($type);
            if ($rule) {
                return (new ReflectionClass($rule))->getShortName();
            }
        }

        return null;
    }
}
