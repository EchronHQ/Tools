<?php

declare(strict_types=1);

namespace Echron\Tools\ArrayHelper;

use Echron\Tools\ArrayHelper;

class HasDuplicatesTest extends \PHPUnit\Framework\TestCase
{
    public function testEmpty()
    {
        $result = ArrayHelper::hasDuplicates([]);
        $this->assertFalse($result);
    }

    public function testStrings()
    {

        $this->assertFalse(ArrayHelper::hasDuplicates(['red', 'green', 'purple']));

        $this->assertTrue(ArrayHelper::hasDuplicates(['red', 'green', 'red']));
    }

    public function testObjects()
    {
        $red = new \stdClass();
        $red->value = 'red';

        $red2 = new \stdClass();
        $red2->value = 'red';

        $green = new \stdClass();
        $green->value = 'green';

        $purple = new \stdClass();
        $purple->value = 'purple';

        $this->assertFalse(ArrayHelper::hasDuplicates([$red, $green, $purple]));

        $this->assertTrue(ArrayHelper::hasDuplicates([$red, $green, $red]));

        $this->assertTrue(ArrayHelper::hasDuplicates([$red, $green, $red2]));
    }
}
