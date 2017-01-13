<?php

namespace PHPRanker;

use DOMNodeList;
use DOMNode;
use DOMDocument;
use DOMElement;

abstract class AbstractParser
{

    protected $content;
    protected $score = [];

    public function __construct($content)
    {
        $this->content = is_file($content) ? file_get_contents($content) : trim($content);
    }

    public function getScore()
    {
        return $this->score;
    }

    protected function getNodes($tagName, AbstractViolation $violation)
    {
        $dom = new DOMDocument();
        @$dom->loadXML($this->content);
        $elements = $dom->getElementsByTagName($tagName);
        foreach ($elements as $element) {
            $payload = [];
            if ($element->getAttribute("name")) {
                $fileName = $element->getAttribute("name");
                foreach ($element->childNodes as $child) {
                    $payload[] = $child;
                }
            } else {
                $fileName  = $element->childNodes->item(1)->getAttribute("path");
                $payload[] = $element;
            }

            isset($this->score[$fileName]) ?: $this->score[$fileName] = 0;

            foreach ($payload as $dom) {
                $attributes = $this->getAttributes($dom);
                if ($attributes) {
                    $point = $violation->add($attributes)->getRemediationPoints();
                    $this->score[$fileName] += $point;
                }
            }
        }

        return $this;
    }

    private function getAttributes($element)
    {
        $attributes = [];
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $attr) {
                $name  = $attr->nodeName;
                $value = $attr->nodeValue;

                $attributes[$name] = $value;
            }
        }

        return $attributes;
    }

    abstract public function parse();
}
