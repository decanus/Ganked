<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects\LeagueOfLegends
{

    /**
     * @covers Ganked\Library\ValueObjects\LeagueOfLegends\Region
     */
    class RegionTest extends  \PHPUnit_Framework_TestCase
    {
        /**
         * @expectedException \InvalidArgumentException
         */
        public function testInvalidRegionThrowsException()
        {
            new Region('foobar');
        }

        public function testWorksWithValidRegion()
        {
            $region = new Region('br');
            $this->assertSame('br', (string) $region);
        }
    }
}
