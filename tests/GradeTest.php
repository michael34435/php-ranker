<?php

use PHPRanker\Grade;

class GradeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_get_points()
    {
        $points = (new Grade(100))->getPoints();
        $this->assertEquals($points, 100);
    }

    /**
     * @test
     */
    public function it_get_rank_and_point()
    {
        $rank = (new Grade(0))->getRank();
        $this->assertEquals($rank, "A");
        $point = (new Grade(0))->getPoint();
        $this->assertEquals($point, 4);
        $rank = (new Grade(1000000))->getRank();
        $this->assertEquals($rank, "A");
        $point = (new Grade(1000000))->getPoint();
        $this->assertEquals($point, 4);
        $rank = (new Grade(2000000))->getRank();
        $this->assertEquals($rank, "A");
        $point = (new Grade(2000000))->getPoint();
        $this->assertEquals($point, 4);

        $rank = (new Grade(3000000))->getRank();
        $this->assertEquals($rank, "B");
        $point = (new Grade(3000000))->getPoint();
        $this->assertEquals($point, 3);
        $rank = (new Grade(4000000))->getRank();
        $this->assertEquals($rank, "B");
        $point = (new Grade(4000000))->getPoint();
        $this->assertEquals($point, 3);

        $rank = (new Grade(5000000))->getRank();
        $this->assertEquals($rank, "C");
        $point = (new Grade(5000000))->getPoint();
        $this->assertEquals($point, 2);
        $rank = (new Grade(8000000))->getRank();
        $this->assertEquals($rank, "C");
        $point = (new Grade(8000000))->getPoint();
        $this->assertEquals($point, 2);

        $rank = (new Grade(9000000))->getRank();
        $this->assertEquals($rank, "D");
        $point = (new Grade(9000000))->getPoint();
        $this->assertEquals($point, 1);
        $rank = (new Grade(16000000))->getRank();
        $this->assertEquals($rank, "D");
        $point = (new Grade(16000000))->getPoint();
        $this->assertEquals($point, 1);

        $rank = (new Grade(17000000))->getRank();
        $this->assertEquals($rank, "F");
        $point = (new Grade(17000000))->getPoint();
        $this->assertEquals($point, 0);
    }
}
