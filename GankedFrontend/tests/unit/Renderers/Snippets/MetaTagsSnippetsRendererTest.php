<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{
    /**
     * @covers Ganked\Frontend\Renderers\MetaTagsSnippetsRenderer
     * @covers \Ganked\Frontend\Renderers\AbstractSnippetRenderer
     */
    class MetaTagsSnippetsRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var MetaTagsSnippetsRenderer
         */
        private $renderer;

        private $metaTags;
        private $template;
        private $model;

        protected function setUp()
        {
            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\StaticPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->template = $this->getMockBuilder(\Ganked\Library\Helpers\DomHelper::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->metaTags = $this->getMockBuilder(\Ganked\Library\ValueObjects\MetaTags::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->renderer = new MetaTagsSnippetsRenderer();
        }

        public function testRendererAppendsMetaTags()
        {
            $node = $this->getMockBuilder(\DOMElement::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->template
                ->expects($this->exactly(2))
                ->method('getFirstElementByTagName')
                ->will($this->returnValue($node));

            $this->model
                ->expects($this->exactly(3))
                ->method('getMetaTags')
                ->will($this->returnValue($this->metaTags));

            $this->template
                ->expects($this->exactly(3))
                ->method('createElement')
                ->will($this->returnValue($node));

            $this->metaTags
                ->expects($this->exactly(2))
                ->method('getDescription')
                ->will($this->returnValue('description'));
            $node->expects($this->at(0))->method('setAttribute')->with('property', 'og:description');
            $node->expects($this->at(1))->method('setAttribute')->with('content', 'description');
            $node->expects($this->at(2))->method('appendChild')->with($node);

            $this->metaTags
                ->expects($this->once())
                ->method('getTitle')
                ->will($this->returnValue('title'));
            $node->expects($this->at(3))->method('setAttribute')->with('property', 'og:title');
            $node->expects($this->at(4))->method('setAttribute')->with('content', 'title - Ganked.net');
            $node->expects($this->at(5))->method('appendChild')->with($node);

            $this->metaTags
                ->expects($this->once())
                ->method('getImage')
                ->will($this->returnValue('image'));

            $this->template
                ->expects($this->once())
                ->method('getElementById')
                ->will($this->returnValue($node));
            $node->expects($this->at(6))->method('setAttribute')->with('content', 'image');

            $node->expects($this->at(7))->method('setAttribute')->with('name', 'description');
            $node->expects($this->at(8))->method('setAttribute')->with('content', 'description');
            $node->expects($this->at(9))->method('appendChild')->with($node);

            $this->renderer->render($this->model, $this->template);

        }
    }
}
