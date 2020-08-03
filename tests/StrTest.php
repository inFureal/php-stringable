<?php


use Infureal\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{

    function testStrOf()
    {
        $str = Str::of('string');
        $this->assertEquals(Str\Stringable::class, get_class($str));
    }

}