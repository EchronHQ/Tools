<?php
declare(strict_types=1);

class NormalizerTest extends \PHPUnit\Framework\TestCase
{

    public function testAllowSlash()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setAllowSlash(true);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a/b', $keyFormatConfig);
        $this->assertEquals('a/b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a//b', $keyFormatConfig);
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a//b///c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_dotAllowed()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setAllowDot(true);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a.b', $keyFormatConfig);
        $this->assertEquals('a.b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a..b', $keyFormatConfig);
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a..b...c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_slashAndDotAllowed()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setAllowDot(true);
        $keyFormatConfig->setAllowSlash(true);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a.b', $keyFormatConfig);
        $this->assertEquals('a.b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a..b', $keyFormatConfig);
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a..b...c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_dashAllowed()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setAllowDash(true);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a-b', $keyFormatConfig);
        $this->assertEquals('a-b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a--b', $keyFormatConfig);
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a--b---c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_backslash()
    {
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a\b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a\\\\b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a\\b\\\c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_math()
    {
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a+b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a++b--c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a*-=b\'c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_AllowPlus()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setAllowPlus(true);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a+b', $keyFormatConfig);
        $this->assertEquals('a+b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a++b--c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a*-=b\'c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_specials()
    {
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a&b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a$b^c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a@b12c');
        $this->assertEquals('a_b12c', $formattedKey);
    }

    public function testFormatKey_specialsChars()
    {
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('aëb');
        $this->assertEquals('aeb', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a$b^c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a@b12c');
        $this->assertEquals('a_b12c', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('aébècç');
        $this->assertEquals('aebecc', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a Τάχιστη b αλώπηξ c βαφής d ψημένη e γη, f δρασκελίζει g υπέρ h νωθρού i κυνός');
        $this->assertEquals('a_b_c_d_e_f_g_h_i', $formattedKey);
    }

    public function testFormatKey_numbers()
    {
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('123');
        $this->assertEquals('123', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('0123');
        $this->assertEquals('0123', $formattedKey);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('3210');
        $this->assertEquals('3210', $formattedKey);
    }

    public function testFormatKey_unwanted()
    {
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('test�test');
        $this->assertEquals('test_test', $formattedKey);
    }

    public function testFormatKey_MaxLength()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setMaxLength(10);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('abcdefghijklmnopqrstuvwxyz', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abcdefghij');
        $this->assertEquals(10, strlen($formattedKey));

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('This is a long long long id', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'this_is_a');
        $this->assertLessThan(10, strlen($formattedKey));

        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setMaxLength(100);

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('Shortid', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'shortid');
        $this->assertEquals(7, strlen($formattedKey));
    }

    public function testFormatKey_Casing()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('aBC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('ABC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('abc', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');

        $keyFormatConfig->setIsCasesAllowed(true);
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('aBC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'aBC');

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('ABC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'ABC');

        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('abc', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');
    }

    public function testFormatKey_extended()
    {
        $keyFormatConfig = new \Echron\Tools\Normalize\NormalizeConfig();
        $keyFormatConfig->setAllowExtended(true);
        $keyFormatConfig->setAllowSlash(true);
        $keyFormatConfig->setAllowPlus(true);
        $keyFormatConfig->setAllowDot(true);
        $keyFormatConfig->setAllowDash(true);
        $formattedKey = \Echron\Tools\Normalize\Normalizer::normalize('a+b/c\d(e)f{g}h*i#j[k]l=m.n_o-p', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'a+b/c\d(e)f{g}h*i#j[k]l=m.n_o-p');
    }
}
