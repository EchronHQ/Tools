<?php
declare(strict_types=1);

use Echron\Tools\Time;

class CreateFromFormatTest extends \PHPUnit\Framework\TestCase
{

    public function testValid()
    {
        $seconds = 10800;

        $now = new DateTime('now');

        $result = Time::createFromFormat($now->format('Y-m-d H:m:s'));

        $this->assertEquals($now->format('Y-m-d H:m:s'), $result->format('Y-m-d H:m:s'));
    }

    public function testInvalid()
    {

        $this->expectException(InvalidArgumentException::class);
//        $this->expectExceptionMessage('test');
        $result = Time::createFromFormat("not a date");
    }
}
