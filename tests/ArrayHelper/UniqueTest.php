<?php
declare(strict_types=1);

use Echron\Tools\ArrayHelper;

class UniqueTest extends \PHPUnit\Framework\TestCase
{

    public function testEmpty()
    {
        $result = ArrayHelper::unique([], []);
        $this->assertEquals([], $result);

        $result = ArrayHelper::unique([], ['fieldname']);
        $this->assertEquals([], $result);
    }

    public function testFlatArray()
    {
        $result = ArrayHelper::unique([
            'a',
            'b',
            'c',
        ], []);
        $this->assertEquals([
            'a',
            'b',
            'c',
        ], $result);
        $result = ArrayHelper::unique([
            'a',
            'b',
            'c',
        ], ['fieldname']);
        $this->assertEquals([
            'a',
            'b',
            'c',
        ], $result);
    }

    public function testNoEquals()
    {
        $input = [
            ['fieldA' => 'valueA'],
            ['fieldB' => 'valueA'],
            [
                'fieldA' => 'valueA2',
                'fieldC' => 'valueA',
            ],
        ];

        $result = ArrayHelper::unique($input, ['fieldB']);
        $this->assertEquals($input, $result);

        $result = ArrayHelper::unique($input, ['fieldA']);
        $this->assertEquals($input, $result);
    }

    public function testEquals()
    {
        $input = [
            ['fieldA' => 'valueA'],
            ['fieldB' => 'valueA'],
            [
                'fieldA' => 'valueA',
                'fieldC' => 'valueA',
            ],
            [
                'fieldB' => 'valueA',
                'fieldC' => 'valueB',
            ],
        ];

        $result = ArrayHelper::unique($input, ['fieldB']);
        $this->assertEquals([
            ['fieldA' => 'valueA'],
            ['fieldB' => 'valueA'],
            [
                'fieldA' => 'valueA',
                'fieldC' => 'valueA',
            ],
        ], $result);

        $result = ArrayHelper::unique($input, ['fieldA']);
        $this->assertEquals([
            ['fieldA' => 'valueA'],
            ['fieldB' => 'valueA'],
            [
                'fieldB' => 'valueA',
                'fieldC' => 'valueB',
            ],
        ], $result);
    }
}
