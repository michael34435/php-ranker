<?php

use PHPRanker\Checkstyle\Parser as CheckstyleParser;
use PHPRanker\PMD\Parser as PMDParser;
use PHPRanker\Dry\Parser as DryParser;

class ParserTest extends PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function it_parse()
    {
        $checkstyleXML = file_get_contents(__DIR__ . "/../example/xml/checkstyle.xml");

        $score = (new CheckstyleParser($checkstyleXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);

        $pmdXML = file_get_contents(__DIR__ . "/../example/xml/pmd.xml");

        $score = (new PMDParser($pmdXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);

        $dryXML = file_get_contents(__DIR__ . "/../example/xml/dry.xml");

        $score = (new DryParser($dryXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);
    }
}
