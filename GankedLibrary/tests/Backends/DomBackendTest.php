<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Backends
{
    /**
     * @covers Ganked\Library\Backends\DomBackend
     * @uses Ganked\Library\Helpers\DomHelper
     */
    class DomBackendTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var DomBackend
         */
        private $domBackend;
        private $fileBackend;

        protected function setUp()
        {
            $this->fileBackend = $this->getMockBuilder(\Ganked\Library\Backends\FileBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->domBackend = new DomBackend($this->fileBackend);
        }

        public function testGetDomFromXMLReturnsExpectedValue()
        {
            $path = '/foo/bar';

            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->with($path)
                ->will($this->returnValue('<div />'));

            $this->assertXmlStringEqualsXmlString('<div />', $this->domBackend->getDomFromXML($path)->saveXML());
        }

        public function testGetXSLReturnsExpectedValue()
        {
            $path = '/foo/bar';

            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->with($path)
                ->will($this->returnValue(
                    '<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
                        <xsl:template match="/"></xsl:template>
                    </xsl:stylesheet>'
                    )
                );

            $this->assertInstanceOf(\XSLTProcessor::class, $this->domBackend->getXSL($path));
        }


    }
}
