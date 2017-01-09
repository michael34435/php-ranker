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
        <?xml version='1.0' encoding='UTF-8'?>
        <annotation-array>
          <warning plugin="checkstyle@3.47">
            <message>Missing @return tag in function comment</message>
            <priority>HIGH</priority>
            <key>-7559494628951881238</key>
            <lineRanges>
              <range plugin="analysis-core@1.81">
                <start>1642</start>
                <end>1642</end>
              </range>
            </lineRanges>
            <primaryLineNumber>1642</primaryLineNumber>
            <fileName>/root/src/Bar.php</fileName>
            <moduleName></moduleName>
            <packageName>-</packageName>
            <category>FunctionComment</category>
            <type>MissingReturn</type>
            <contextHashCode>2107145544</contextHashCode>
            <origin>checkstyle</origin>
            <pathName>src</pathName>
            <primaryColumnStart>6</primaryColumnStart>
            <primaryColumnEnd>6</primaryColumnEnd>
            <build>0</build>
          </warning>
          <warning plugin="checkstyle@3.47">
            <message>Doc comment for parameter &quot;$shippingName&quot; missing</message>
            <priority>HIGH</priority>
            <key>-7559494628951882360</key>
            <lineRanges>
              <range plugin="analysis-core@1.81">
                <start>2076</start>
                <end>2076</end>
              </range>
            </lineRanges>
            <primaryLineNumber>2076</primaryLineNumber>
            <fileName>/root/src/Foo.php</fileName>
            <moduleName reference="../../warning/moduleName"/>
            <packageName reference="../../warning/packageName"/>
            <category>FunctionComment</category>
            <type>MissingParamTag</type>
            <contextHashCode>334311350</contextHashCode>
            <origin>checkstyle</origin>
            <pathName>src</pathName>
            <primaryColumnStart>5</primaryColumnStart>
            <primaryColumnEnd>5</primaryColumnEnd>
            <build>0</build>
          </warning>
        </annotation-array>
EOT;

        $score = (new CheckstyleParser($checkstyleXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Bar.php", $score);
        $this->assertArrayHasKey("/root/src/Foo.php", $score);

        $pmdXML = <<<'EOT'
        <?xml version='1.0' encoding='UTF-8'?>
        <annotation-array>
          <bug plugin="pmd@3.46">
            <message>The method foo() has a Cyclomatic Complexity of 24. The configured cyclomatic complexity threshold is 10.</message>
            <priority>NORMAL</priority>
            <key>7847236815694452825</key>
            <lineRanges>
              <range plugin="analysis-core@1.81">
                <start>1173</start>
                <end>1304</end>
              </range>
            </lineRanges>
            <primaryLineNumber>1173</primaryLineNumber>
            <fileName>/root/src/Bar.php</fileName>
            <moduleName></moduleName>
            <packageName>Foo</packageName>
            <category>Code Size Rules</category>
            <type>CyclomaticComplexity</type>
            <contextHashCode>-684900959</contextHashCode>
            <origin>pmd</origin>
            <pathName>src/Service</pathName>
            <primaryColumnStart>0</primaryColumnStart>
            <primaryColumnEnd>0</primaryColumnEnd>
            <build>0</build>
            <tooltip></tooltip>
          </bug>
          <bug plugin="pmd@3.46">
            <message>The method foo() has an NPath complexity of 31250. The configured NPath complexity threshold is 200.</message>
            <priority>NORMAL</priority>
            <key>7847236815694452574</key>
            <lineRanges>
              <range plugin="analysis-core@1.81">
                <start>284</start>
                <end>310</end>
              </range>
            </lineRanges>
            <primaryLineNumber>284</primaryLineNumber>
            <fileName>/root/src/Foo.php</fileName>
            <moduleName reference="../../bug/moduleName"/>
            <packageName>Foo</packageName>
            <category>Code Size Rules</category>
            <type>NPathComplexity</type>
            <contextHashCode>877045939</contextHashCode>
            <origin>pmd</origin>
            <pathName>src</pathName>
            <primaryColumnStart>0</primaryColumnStart>
            <primaryColumnEnd>0</primaryColumnEnd>
            <build>0</build>
            <tooltip></tooltip>
          </bug>
        </annotation-array>
EOT;

        $score = (new PMDParser($pmdXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Bar.php", $score);
        $this->assertArrayHasKey("/root/src/Foo.php", $score);

        $dryXML = <<<'EOT'
        <?xml version='1.0' encoding='UTF-8'?>
        <annotation-array>
        <dry plugin="dry@2.46">
          <message>20 lines of duplicate code.</message>
          <priority>LOW</priority>
          <key>-7559494628951881069</key>
          <lineRanges>
            <range plugin="analysis-core@1.81">
              <start>1794</start>
              <end>1813</end>
            </range>
          </lineRanges>
          <primaryLineNumber>1794</primaryLineNumber>
          <fileName>/root/src/Foo.php</fileName>
          <moduleName></moduleName>
          <packageName>-</packageName>
          <category></category>
          <type>Duplicate Code</type>
          <contextHashCode>49367681184</contextHashCode>
          <origin>dry</origin>
          <pathName>src</pathName>
          <primaryColumnStart>0</primaryColumnStart>
          <primaryColumnEnd>0</primaryColumnEnd>
          <build>0</build>
          <links>
            <dry>
              <message>20 lines of duplicate code.</message>
              <priority>LOW</priority>
              <key>-7559494628951881068</key>
              <lineRanges>
                <range plugin="analysis-core@1.81">
                  <start>1839</start>
                  <end>1858</end>
                </range>
              </lineRanges>
              <primaryLineNumber>1839</primaryLineNumber>
              <fileName>/root/src/Foo.php</fileName>
              <moduleName></moduleName>
              <packageName>-</packageName>
              <category></category>
              <type>Duplicate Code</type>
              <contextHashCode>41110010304</contextHashCode>
              <origin>dry</origin>
              <pathName>src/Service</pathName>
              <primaryColumnStart>0</primaryColumnStart>
              <primaryColumnEnd>0</primaryColumnEnd>
              <build>0</build>
              <links>
                <dry reference="../../../.."/>
              </links>
              <sourceCode></sourceCode>
              <number>-1842373466</number>
              <isDerived>false</isDerived>
            </dry>
          </links>
          <sourceCode></sourceCode>
          <number>-1842373466</number>
          <isDerived>false</isDerived>
        </dry>
      </annotation-array>
EOT;

        $score = (new DryParser($dryXML))->parse()->getScore();
        $this->assertArrayHasKey("/root/src/Foo.php", $score);
    }
}
