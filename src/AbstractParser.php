<?php

namespace PHPRanker;

use DOMNodeList;
use DOMNode;
use DOMDocument;

abstract class AbstractParser
{

    protected $content;
    protected $score = [];

    public function __construct($content)
    {
        $this->content = is_file($content) ? file_get_contents($content) : $content;
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
            if ($element->getAttribute("plugin")) {
                $nodes    = $this->getNodeValue($element->childNodes);
                $point    = $violation->addViolation($nodes)->getRemediationPoints();
                $fileName = $nodes["fileName"];
                $this->score[$fileName]  = isset($this->score[$fileName]) ? $this->score[$fileName] : 0;
                $this->score[$fileName] += $point;
            }
        }

        return $this;
    }

    protected function getReference(DOMNode $node, $reference)
    {
        $reference = preg_split("/\//", $reference, null, PREG_SPLIT_NO_EMPTY);
        foreach ($reference as $ref) {
            if ($ref === "..") {
                $node = $node->parentNode;
            } elseif ($ref !== end($reference)) {
                preg_match("/(\[(\d+)\])$/", $ref, $index);
                $pos     = $index ? -1 : 0;
                $item    = array_pop($index) ?: 0;
                $item    = (int) $item + $pos;
                $replace = array_pop($index);
                $ref     = str_replace($replace, "", $ref);
                $node    = $node->getElementsByTagName($ref)->item($item);
            } else {
                $node = $node->getElementsByTagName($ref)->item(0);
            }
        }

        return $node;
    }

    protected function getNodeValue(DOMNodeList $nodes)
    {
        $elements = [];
        foreach ($nodes as $node) {
            if ($node->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            $reference = $node->getAttribute("reference");
            $target    = $this->getReference($node, $reference);
            if ($target->childNodes->length > 1) {
                $elements[$target->tagName] = $target->childNodes;
            } else {
                $elements[$target->tagName] = $target->textContent;
            }
        }

        return $elements;
    }

    abstract public function parse();
}
