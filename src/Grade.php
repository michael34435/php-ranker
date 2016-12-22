<?php

namespace PHPRanker;

class Grade
{

    protected $rank;
    protected $point;
    protected $points;

    protected $ratings = [
        "A" => [0, 2000000, 4],
        "B" => [2000000, 4000000, 3],
        "C" => [4000000, 8000000, 2],
        "D" => [8000000, 16000000, 1],
        "F" => [16000000, PHP_INT_MAX, 0],
    ];

    public function __construct($points = 0)
    {
        foreach ($this->ratings as $rank => $rating) {
            $min   = $rating[0];
            $max   = $rating[1];
            $point = $rating[2];

            if ($points >= $min && $points < $max) {
                $ratio       = 1 / ($max - $min);
                $plus        = $ratio * ($points - $min);
                $point       = $point - $plus;
                $point       = $point < 0 ? 0 : $point;
                $this->rank  = $rank;
                $this->point = round($point, 2);
            }
        }

        $this->points = $points;
    }

    public function getPoint()
    {
        return $this->point;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getRank()
    {
        return $this->rank;
    }
}
