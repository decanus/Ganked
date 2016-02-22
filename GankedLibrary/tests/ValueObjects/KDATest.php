<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\ValueObjects
{

    class KDATest extends \PHPUnit_Framework_TestCase
    {
        public function testKDAWorksWhenDeathsIsZero()
        {
            $kda = new KDA(4, 0, 4);
            $this->assertSame('8', (string) $kda);
        }

        public function testKDAWorks()
        {
            $kda = new KDA(4, 4, 4);
            $this->assertSame('2', (string) $kda);
        }
    }
}
