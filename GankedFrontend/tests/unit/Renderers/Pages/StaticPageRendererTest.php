<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Frontend\Renderers\StaticPageRenderer
     * @covers \Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Library\Helpers\DomHelper
     */
    class StaticPageRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var StaticPageRenderer
         */
        private $renderer;
        private $model;
        private $domBackend;
        private $template;
        private $snippetTransformation;
        private $metaTags;
        private $rendererLocator;
        private $genericPageRenderer;

        protected function setUp()
        {
            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\StaticPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->domBackend = $this->getMockBuilder(\Ganked\Library\Backends\DomBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->template = new DomHelper('<html><head id="header"><title/></head><body/></html>');
            $this->genericPageRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\GenericPageRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->snippetTransformation = $this->getMockBuilder(\Ganked\Skeleton\Transformations\SnippetTransformation::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->metaTags = $this->getMockBuilder(\Ganked\Library\ValueObjects\MetaTags::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->rendererLocator = $this->getMockBuilder(\Ganked\Frontend\Locators\RendererLocator::class)
                ->disableOriginalConstructor()
                ->getMock();

            $textTransformation = $this->getMockBuilder(\Ganked\Skeleton\Transformations\TextTransformation::class)
                ->disableOriginalConstructor()
                ->getMock();;

            $this->renderer = new StaticPageRenderer(
                $this->domBackend,
                $this->template,
                $this->snippetTransformation,
                $textTransformation,
                $this->genericPageRenderer,
                $this->rendererLocator
            );
        }

        public function testRenderWorks()
        {
            $this->model
                ->expects($this->once())
                ->method('getTemplate')
                ->will($this->returnValue(new DomHelper('<body><div></div></body>')));

            $this->model
                ->expects($this->once())
                ->method('getMetaTags')
                ->will($this->returnValue($this->metaTags));
            $this->model
                ->expects($this->once())
                ->method('getRequestUri')
                ->will($this->returnValue(new Uri('ganked.test')));

            $this->snippetTransformation
                ->expects($this->at(0))
                ->method('setTemplate');
            $this->snippetTransformation
                ->expects($this->at(1))
                ->method('replaceElementWithId');

            $this->genericPageRenderer
                ->expects($this->once())
                ->method('render');

            $this->renderer->render($this->model);
        }
    }
}
