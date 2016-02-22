<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\ValueObjects
{

    class MapTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @expectedException \InvalidArgumentException
         */
        public function testInvalidMapSetsException()
        {
            new Map(50);
        }

        public function testMapWorks()
        {
            $this->assertSame('summoners-rift', (string) new Map(1));
        }
    }
}
