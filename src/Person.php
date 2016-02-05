<?php

namespace App;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Person
{
    /**
     * @var string
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
