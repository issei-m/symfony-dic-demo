<?php

namespace App\Greeter;

use App\Person;
use App\Greeter;
use App\Service\WellTimedGreetingPhraseMaker;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
final class PoliteGreeter implements Greeter
{
    /**
     * @var WellTimedGreetingPhraseMaker
     */
    private $greetingPhraseMaker;

    public function __construct(WellTimedGreetingPhraseMaker $greetingPhraseMaker)
    {
        $this->greetingPhraseMaker = $greetingPhraseMaker;
    }

    /**
     * {@inheritdoc}
     */
    public function askName()
    {
        return 'お名前を教えて下さい';
    }

    /**
     * {@inheritdoc}
     */
    public function greet(Person $person)
    {
        return sprintf($person->getName() . 'さん、%s。', $this->greetingPhraseMaker->phrase());
    }
}
