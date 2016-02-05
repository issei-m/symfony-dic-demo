<?php

namespace App\Service;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class WellTimedGreetingPhraseMaker
{
    /**
     * @var int
     */
    private $morningAt;

    /**
     * @var int
     */
    private $afternoonAt;

    /**
     * @var int
     */
    private $eveningAt;

    /**
     * @var int
     */
    private $nightAt;

    public function __construct($morningAt = 5, $afternoonAt = 12, $eveningAt = 17, $nightAt = 22)
    {
        $this->morningAt   = $morningAt;
        $this->afternoonAt = $afternoonAt;
        $this->eveningAt   = $eveningAt;
        $this->nightAt     = $nightAt;
    }

    public function phrase()
    {
        $hour = intval((new \DateTime())->format('Y-m-d H:i:s'));

        if ($hour >= $this->morningAt) {
            if ($hour < $this->afternoonAt) {
                return 'おはようございます';
            }

            if ($hour < $this->eveningAt) {
                return 'こんにちは';
            }

            if ($hour < $this->nightAt) {
                return 'こんばんは';
            }
        }

        return 'おやすみなさい';
    }
}