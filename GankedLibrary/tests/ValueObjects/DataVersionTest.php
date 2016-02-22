<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{

    /**
     * @covers Ganked\Library\ValueObjects\DataVersion
     */
    class DataVersionTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @expectedException \InvalidArgumentException
         */
        public function testInvalidFormatThrowsException()
        {
            new DataVersion('foo');
        }

        public function testWorksWithValidVersion()
        {
            $dataVersion = new DataVersion('20150909-2332');
            $this->assertSame('20150909-2332', (string) $dataVersion);
        }
    }
}
