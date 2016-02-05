<?php

namespace App\Greeter;

use App\Person;
use App\Greeter;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
final class RudeGreeter implements Greeter
{
    /**
     * {@inheritdoc}
     */
    public function askName()
    {
        return '名前おしえちくりーｗｗ';
    }

    /**
     * {@inheritdoc}
     */
    public function greet(Person $person)
    {
        return $person->getName() . 'ちゃん、ちーっすｗｗ';
    }
}
