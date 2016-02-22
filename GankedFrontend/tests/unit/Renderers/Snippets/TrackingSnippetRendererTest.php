<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @covers \Ganked\Frontend\Renderers\AbstractSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class TrackingSnippetRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var TrackingSnippetRenderer
         */
        private $renderer;

        private $domBackend;
        private $template;
        private $model;

        protected function setUp()
        {
            $this->domBackend = $this->getMockBuilder(\Ganked\Library\Backends\DomBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->template = $this->getMockBuilder(\Ganked\Library\Helpers\DomHelper::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\StaticPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->renderer = new TrackingSnippetRenderer($this->domBackend);
        }

        public function testRendererAppendsTrackingSnippet()
        {
            $this->template
                ->expects($this->once())
                ->method('getFirstElementByTagName')
                ->with('body')
                ->will($this->returnValue(new \DOMNode));

            $this->domBackend
                ->expects($this->once())
                ->method('getDomFromXML')
                ->with('templates://tracking/googleAnalytics.xml')
                ->will($this->returnValue(new DomHelper('<div></div>')));

            $this->template
                ->expects($this->once())
                ->method('importAndAppendChild');

            $this->renderer->render($this->model, $this->template);
        }
    }
}
