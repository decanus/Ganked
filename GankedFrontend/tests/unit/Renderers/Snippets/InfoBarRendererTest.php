<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Frontend\Renderers\InfoBarRenderer
     */
    class InfoBarRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var InfoBarRenderer
         */
        private $render;
        private $dataPoolReader;

        /**
         * @var DomHelper
         */
        private $template;

        protected function setUp()
        {
            $this->dataPoolReader = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->template = new DomHelper('<body><infoBar /></body>');

            $this->render = new InfoBarRenderer($this->dataPoolReader);
        }

        public function testDoesNotRenderWhenMessageIsDisabled()
        {
            $this->dataPoolReader
                ->expects($this->once())
                ->method('isInfoBarEnabled')
                ->will($this->returnValue(false));
            $this->assertNull($this->render->render($this->template));
        }

        public function testDoesNotRenderWhenMessageIsEmpty()
        {
            $this->dataPoolReader
                ->expects($this->once())
                ->method('isInfoBarEnabled')
                ->will($this->returnValue(true));
            $this->dataPoolReader
                ->expects($this->once())
                ->method('getInfoBarMessage')
                ->will($this->returnValue(false));
            $this->assertNull($this->render->render($this->template));
        }

        public function testRenderWorks()
        {

            $this->dataPoolReader
                ->expects($this->once())
                ->method('isInfoBarEnabled')
                ->will($this->returnValue(true));
            $this->dataPoolReader
                ->expects($this->once())
                ->method('getInfoBarMessage')
                ->will($this->returnValue('fo<span>o</span>'));

            $this->render->render($this->template);

            $this->assertXmlStringEqualsXmlString(
                '<body><div class="page-banner">fo<span>o</span></div></body>',
                $this->template->saveXML()
            );
        }
    }
}
