<?php

namespace App;

use App\Greeter;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Application
{
    /**
     * @var Greeter
     */
    private $greeter;

    public function __construct(Greeter $greeter)
    {
        $this->greeter = $greeter;
    }

    public function run()
    {
        fwrite(STDIN, $this->greeter->askName() . ': ');

        $person = new Person(trim(fgets(STDIN)));

        fwrite(STDIN, $this->greeter->greet($person) . "\n");
    }
}
