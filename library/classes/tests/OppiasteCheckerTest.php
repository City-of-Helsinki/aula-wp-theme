<?php

namespace LuuptekWP\tests;

use Oppiaste_checker;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Oppiaste-checker.php';

class OppiasteCheckerTest extends TestCase
{
    public function testEmptyInputReturnsNull()
    {
        $this->assertNull(Oppiaste_checker::get_oppiaste_value(null));
        $this->assertNull(Oppiaste_checker::get_oppiaste_value(''));
    }

    public function testNumericInputReturnsSameNumber()
    {
        $this->assertSame(5, Oppiaste_checker::get_oppiaste_value(5));
        $this->assertSame(10, Oppiaste_checker::get_oppiaste_value('10'));
    }

    public function testSingleNumbersInString()
    {
        $this->assertSame(3, Oppiaste_checker::get_oppiaste_value('L3'));
        $this->assertSame(9, Oppiaste_checker::get_oppiaste_value('9'));
    }

    public function testMultipleNumbersInString()
    {
        $this->assertSame(4, Oppiaste_checker::get_oppiaste_value('L1;L3;L4'));
        $this->assertSame(3, Oppiaste_checker::get_oppiaste_value('L2;L3'));
        $this->assertSame(3, Oppiaste_checker::get_oppiaste_value('L2;L3'));
    }

    public function testNoNumbersReturnsNull()
    {
        $this->assertNull(Oppiaste_checker::get_oppiaste_value('abc'));
        $this->assertNull(Oppiaste_checker::get_oppiaste_value('!@#$'));
    }
}