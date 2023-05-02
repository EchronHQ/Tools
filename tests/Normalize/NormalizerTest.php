<?php
declare(strict_types=1);

namespace Echron\Tools\Normalize;

class NormalizerTest extends \PHPUnit\Framework\TestCase
{

    public function testAllowSlash()
    {
        $keyFormatConfig1 = new NormalizeConfig();
        $keyFormatConfig1->setAllowSlash(true, 1);

        $keyFormatConfig2 = new NormalizeConfig();
        $keyFormatConfig2->setAllowSlash(true, 2);

        $keyFormatConfig3 = new NormalizeConfig();
        $keyFormatConfig3->setAllowSlash(true, 10);


        $this->assertEquals('a/b', Normalizer::normalize('a/b', $keyFormatConfig1));
        $this->assertEquals('a/b', Normalizer::normalize('a/b', $keyFormatConfig2));
        $this->assertEquals('a/b', Normalizer::normalize('a/b', $keyFormatConfig3));


        $this->assertEquals('a/b', Normalizer::normalize('a//b', $keyFormatConfig1));
        $this->assertEquals('a//b', Normalizer::normalize('a//b', $keyFormatConfig2));
        $this->assertEquals('a//b', Normalizer::normalize('a//b', $keyFormatConfig3));


        $this->assertEquals('a/b/c', Normalizer::normalize('a//b///c', $keyFormatConfig1));
        $this->assertEquals('a//b//c', Normalizer::normalize('a//b///c', $keyFormatConfig2));
        $this->assertEquals('a//b///c', Normalizer::normalize('a//b///c', $keyFormatConfig3));
    }

    public function testFormatKey_dotAllowed()
    {
        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setAllowDot(true);

        $formattedKey = Normalizer::normalize('a.b', $keyFormatConfig);
        $this->assertEquals('a.b', $formattedKey);

        $formattedKey = Normalizer::normalize('a..b', $keyFormatConfig);
        $this->assertEquals('a.b', $formattedKey);

        $formattedKey = Normalizer::normalize('a..b...c', $keyFormatConfig);
        $this->assertEquals('a.b.c', $formattedKey);
    }

    public function testFormatKey_slashAndDotAllowed()
    {
        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setAllowDot(true);
        $keyFormatConfig->setAllowSlash(true);

        $formattedKey = Normalizer::normalize('a.b', $keyFormatConfig);
        $this->assertEquals('a.b', $formattedKey);

        $formattedKey = Normalizer::normalize('a..b', $keyFormatConfig);
        $this->assertEquals('a.b', $formattedKey);

        $formattedKey = Normalizer::normalize('a..b...c', $keyFormatConfig);
        $this->assertEquals('a.b.c', $formattedKey);
    }

    public function testFormatKey_dashAllowed()
    {
        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setAllowDash(true);

        $formattedKey = Normalizer::normalize('a-b', $keyFormatConfig);
        $this->assertEquals('a-b', $formattedKey);

        $formattedKey = Normalizer::normalize('a--b', $keyFormatConfig);
        $this->assertEquals('a-b', $formattedKey);

        $formattedKey = Normalizer::normalize('a--b---c', $keyFormatConfig);
        $this->assertEquals('a-b-c', $formattedKey);
    }

    public function testFormatKey_backslash()
    {
        $formattedKey = Normalizer::normalize('a\b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = Normalizer::normalize('a\\\\b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = Normalizer::normalize('a\\b\\\c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_math()
    {
        $formattedKey = Normalizer::normalize('a+b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = Normalizer::normalize('a++b--c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = Normalizer::normalize('a*-=b\'c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_AllowPlus()
    {
        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setAllowPlus(true);

        $formattedKey = Normalizer::normalize('a+b', $keyFormatConfig);
        $this->assertEquals('a+b', $formattedKey);

        $formattedKey = Normalizer::normalize('a++b--c', $keyFormatConfig);
        $this->assertEquals('a++b_c', $formattedKey);

        $formattedKey = Normalizer::normalize('a+++b--c', $keyFormatConfig);
        $this->assertEquals('a+++b_c', $formattedKey);

        $formattedKey = Normalizer::normalize('a*-=b\'c', $keyFormatConfig);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_specials()
    {
        $formattedKey = Normalizer::normalize('a&b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = Normalizer::normalize('a$b^c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = Normalizer::normalize('a@b12c');
        $this->assertEquals('a_b12c', $formattedKey);
    }

    public function testFormatKey_specialsChars()
    {
        $formattedKey = Normalizer::normalize('aëb');
        $this->assertEquals('aeb', $formattedKey);

        $formattedKey = Normalizer::normalize('a$b^c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = Normalizer::normalize('a@b12c');
        $this->assertEquals('a_b12c', $formattedKey);

        $formattedKey = Normalizer::normalize('aébècç');
        $this->assertEquals('aebecc', $formattedKey);

        $formattedKey = Normalizer::normalize('a Τάχιστη b αλώπηξ c βαφής d ψημένη e γη, f δρασκελίζει g υπέρ h νωθρού i κυνός');
        $this->assertEquals('a_b_c_d_e_f_g_h_i', $formattedKey);
    }

    public function testFormatKey_numbers()
    {
        $formattedKey = Normalizer::normalize('123');
        $this->assertEquals('123', $formattedKey);

        $formattedKey = Normalizer::normalize('0123');
        $this->assertEquals('0123', $formattedKey);

        $formattedKey = Normalizer::normalize('3210');
        $this->assertEquals('3210', $formattedKey);
    }

    public function testFormatKey_unwanted()
    {
        $formattedKey = Normalizer::normalize('test�test');
        $this->assertEquals('test_test', $formattedKey);
    }

    public function testFormatKey_MaxLength()
    {
        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setMaxLength(10);

        $formattedKey = Normalizer::normalize('abcdefghijklmnopqrstuvwxyz', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abcdefghij');
        $this->assertEquals(10, strlen((string)$formattedKey));

        $formattedKey = Normalizer::normalize('This is a long long long id', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'this_is_a');
        $this->assertLessThan(10, strlen((string)$formattedKey));

        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setMaxLength(100);

        $formattedKey = Normalizer::normalize('Shortid', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'shortid');
        $this->assertEquals(7, strlen((string)$formattedKey));
    }

    public function testFormatKey_Casing()
    {
        $keyFormatConfig = new NormalizeConfig();

        $formattedKey = Normalizer::normalize('aBC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');

        $formattedKey = Normalizer::normalize('ABC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');

        $formattedKey = Normalizer::normalize('abc', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');

        $keyFormatConfig->setIsCasesAllowed(true);
        $formattedKey = Normalizer::normalize('aBC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'aBC');

        $formattedKey = Normalizer::normalize('ABC', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'ABC');

        $formattedKey = Normalizer::normalize('abc', $keyFormatConfig);
        $this->assertEquals($formattedKey, 'abc');
    }

    public function testFormatKey_extended()
    {
        $keyFormatConfig = new NormalizeConfig();
        $keyFormatConfig->setAllowExtended(true);
        $keyFormatConfig->setAllowSlash(true);
        $keyFormatConfig->setAllowPlus(true);
        $keyFormatConfig->setAllowDot(true);
        $keyFormatConfig->setAllowDash(true);
        $formattedKey = Normalizer::normalize('a+b/c\d(e)f{g}h*i#j[k]l=m.n_o-p', $keyFormatConfig);
        $this->assertEquals('a+b/c\d(e)f{g}h*i#j[k]l=m.n_o-p', $formattedKey);
    }
}
