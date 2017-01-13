<?php

use PHPRanker\Checkstyle\Parser as CheckstyleParser;
use PHPRanker\PMD\Parser as PMDParser;
use PHPRanker\Dry\Parser as DryParser;

class ParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_parse()
    {
        $checkstyleXML = <<<'EOT'
        <?xml version="1.0" encoding="UTF-8"?>
<checkstyle version="2.7.1">
<file name="/root/src/Foo.php">
 <error line="1491" column="21" severity="error" message="End comment for long condition not found; expected &quot;//end foreach&quot;" source="Squiz.Commenting.LongConditionClosingComment.Missing"/>
 <error line="2177" column="8" severity="warning" message="Comment refers to a TODO task" source="Generic.Commenting.Todo.CommentFound"/>
</file>
</checkstyle>
EOT;

        $score = (new CheckstyleParser($checkstyleXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);

        $pmdXML = <<<'EOT'
        <?xml version="1.0" encoding="UTF-8" ?>
<pmd version="@project.version@" timestamp="2017-01-11T16:26:40+08:00">
  <file name="/root/src/Foo.php">
    <violation beginline="22" endline="553" rule="ExcessiveClassComplexity" ruleset="Code Size Rules" package="Bar" externalInfoUrl="http://phpmd.org/rules/codesize.html#excessiveclasscomplexity" class="Foo" priority="3">
      The class AberrantBySystemService has an overall complexity of 75 which is very high. The configured complexity threshold is 50.
    </violation>
  </file>
</pmd>
EOT;

        $score = (new PMDParser($pmdXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);

        $dryXML = <<<'EOT'
        <?xml version="1.0" encoding="UTF-8"?>
<pmd-cpd>
  <duplication lines="20" tokens="89">
    <file path="/root/src/Foo.php" line="1870"/>
    <file path="/root/src/Foo.php" line="1917"/>
    <codefragment>
    </codefragment>
  </duplication>
</pmd-cpd>
EOT;

        $score = (new DryParser($dryXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);
    }
}
