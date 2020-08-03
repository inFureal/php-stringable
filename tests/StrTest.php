<?php


use Infureal\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{

    function testStrOf()
    {

        $str = Str::of('string');
        $this->isInstanceOf(Str\Stringable::class);

    }

}