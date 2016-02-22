<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\StatisticNumber
     */
    class StatisticNumberTest extends \PHPUnit_Framework_TestCase
    {
        public function testConstructWorks()
        {
            $statisticNumber = new StatisticNumber(10.5);
            $this->assertEquals('10.5', (string) $statisticNumber);

            $statisticNumber = new StatisticNumber(10);
            $this->assertEquals('10', (string) $statisticNumber);
        }

        public function testInvalidNumberThrowsException()
        {
            $this->setExpectedException(\InvalidArgumentException::class);

            new StatisticNumber('10');
        }

        public function testRoundingWorks()
        {
            $statisticNumber = new StatisticNumber(45300);
            $this->assertEquals('45.3 K', $statisticNumber->getRounded());

            $statisticNumber = new StatisticNumber(43);
            $this->assertEquals('43', $statisticNumber->getRounded());
        }
    }
}
