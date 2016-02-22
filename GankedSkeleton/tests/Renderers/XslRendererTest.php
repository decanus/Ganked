<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Renderers
{
    /**
     * @covers Ganked\Skeleton\Renderers\XslRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class XslRendererTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteReturnsExpectedDom()
        {
            $domBackend = $this->getMockBuilder(\Ganked\Library\Backends\DomBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $renderer = new XslRenderer($domBackend);

            $path = 'foo';
            $domHelper = $this->getMockBuilder(\Ganked\Library\Helpers\DomHelper::class)
                ->disableOriginalConstructor()
                ->getMock();

            $xsl = $this->getMockBuilder(\XSLTProcessor::class)->disableOriginalConstructor()->getMock();
            $domBackend->expects($this->once())->method('getXsl')->with($path)->will($this->returnValue($xsl));
            $xsl->expects($this->once())->method('transformToXml')->with($domHelper)->will($this->returnValue('<div />'));

            $this->assertInstanceOf(\Ganked\Library\Helpers\DomHelper::class, $renderer->render($path, $domHelper));
        }
    }
}
