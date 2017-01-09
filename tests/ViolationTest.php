<?php

use PHPRanker\PMD\Violation as PMDViolation;
use PHPRanker\Dry\Violation as DryViolation;
use PHPRanker\Checkstyle\Violation as CheckstyleViolation;

class ViolationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_pmd_violation()
    {
        // unknown key
        $remediation = (new PMDViolation())
            ->add(["foo" => "Foo"])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // unknown type
        $remediation = (new PMDViolation())
            ->add(["type" => "Foo"])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // normal
        $remediation = (new PMDViolation())
            ->add(["type" => "TooManyMethods"])
            ->getRemediationPoints();
        $this->assertGreaterThan(0, $remediation);
    }

    /**
     * @test
     */
    public function it_dry_violation()
    {
        // unknown key
        $remediation = (new DryViolation())
            ->add(["foo" => "Foo"])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // empty
        $remediation = (new DryViolation())
            ->add(["sourceCode" => ""])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // shoter than 28 token
        $remediation = (new DryViolation())
            ->add(["sourceCode" => "echo 1;"])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // normal, greater than 28
        $remediation = (new DryViolation())
            ->add(["sourceCode" => "echo 1;echo 1;echo 1;echo 1;echo 1;echo 1;echo 1;echo 1;echo 1;echo 1;"])
            ->getRemediationPoints();
        $this->assertGreaterThan(0, $remediation);
    }

    /**
     * @test
     */
    public function it_checkstyle_violation()
    {
        // unknown type
        $remediation = (new CheckstyleViolation())
            ->add(["foo" => "Foo"])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // unknown type
        $remediation = (new CheckstyleViolation())
            ->add(["type" => "Foo"])
            ->getRemediationPoints();
        $this->assertEquals(0, $remediation);

        // normal, use category
        $remediation = (new CheckstyleViolation())
            ->add(["type" => "ClassDefinitionNameSpacing"])
            ->getRemediationPoints();
        $this->assertGreaterThan(0, $remediation);

        // normal, use type
        $remediation = (new CheckstyleViolation())
            ->add(["category" => "ClassDefinitionNameSpacing"])
            ->getRemediationPoints();
        $this->assertGreaterThan(0, $remediation);
    }

    /**
     * @test
     */
    public function it_violation_null()
    {
        try {
            (new DryViolation())->add(null);
        } catch (Error $e) {
            $this->assertEquals(get_class($e), TypeError::class);
        } catch (Exception $e) {
            $this->assertEquals(get_class($e), InvalidArgumentException::class);
        }

        try {
            (new CheckstyleViolation())->add(null);
        } catch (Error $e) {
            $this->assertEquals(get_class($e), TypeError::class);
        } catch (Exception $e) {
            $this->assertEquals(get_class($e), InvalidArgumentException::class);
        }

        try {
            (new PMDViolation())->add(null);
        } catch (Error $e) {
            $this->assertEquals(get_class($e), TypeError::class);
        } catch (Exception $e) {
            $this->assertEquals(get_class($e), InvalidArgumentException::class);
        }
    }

    /**
     * @test
     */
    public function it_violation_empty()
    {
        $dryRemediation        = (new DryViolation())->add([])->getRemediationPoints();
        $pmdRemediation        = (new PMDViolation())->add([])->getRemediationPoints();;
        $checkstyleRemediation = (new CheckstyleViolation())->add([])->getRemediationPoints();;

        $this->assertEquals(0, $dryRemediation);
        $this->assertEquals(0, $pmdRemediation);
        $this->assertEquals(0, $checkstyleRemediation);
    }
}
