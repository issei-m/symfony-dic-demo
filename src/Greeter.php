<?php

namespace App;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
interface Greeter
{
    /**
     * 名前を伺う文を作成する
     *
     * @return string
     */
    public function askName();

    /**
     * 受け取った人物に対して挨拶をする
     *
     * @param Person $person
     *
     * @return string
     */
    public function greet(Person $person);
}
