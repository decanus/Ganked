<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Frontend\Renderers\BarGraphRenderer
     */
    class BarGraphRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var BarGraphRenderer
         */
        private $renderer;

        protected function setUp()
        {
            $this->renderer = new BarGraphRenderer();
        }

        public function testBarGraphRendererWorks()
        {
            $result = $this->renderer->render('2', '10', 'foo', 'purple');
            $this->assertInstanceOf(\DomNode::class, $result);

            $template = new DomHelper('<div />');
            $template->importAndAppendChild($template->firstChild, $result);

            $this->assertXmlStringEqualsXmlString(
                file_get_contents(__DIR__ . '/../../../data/renderers/bargraph.xml'),
                $template->saveXML()
            );
        }
    }
}
