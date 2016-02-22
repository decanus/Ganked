<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    /**
     * @covers Ganked\Frontend\Renderers\GenericPageRenderer
     */
    class GenericPageRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var GenericPageRenderer
         */
        private $genericPageRenderer;
        private $template;
        private $model;
        private $signInLinksSnippetRenderer;
        private $metaTagsSnippetsRenderer;
        private $trackingSnippetRenderer;
        private $headerSnippetRenderer;
        private $appendCSRFTokenSnippetRenderer;
        private $infoBarRenderer;

        protected function setUp()
        {
            $this->appendCSRFTokenSnippetRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->headerSnippetRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\HeaderSnippetRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->trackingSnippetRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\TrackingSnippetRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->metaTagsSnippetsRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\MetaTagsSnippetsRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->signInLinksSnippetRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\SignInLinksSnippetRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->infoBarRenderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\InfoBarRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = $this->getMockBuilder(\Ganked\Skeleton\Models\AbstractPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->template = $this->getMockBuilder(\Ganked\Library\Helpers\DomHelper::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->genericPageRenderer = new GenericPageRenderer(
                $this->signInLinksSnippetRenderer,
                $this->metaTagsSnippetsRenderer,
                $this->trackingSnippetRenderer,
                $this->headerSnippetRenderer,
                $this->appendCSRFTokenSnippetRenderer,
                $this->infoBarRenderer
            );
        }

        public function testRenderWorks()
        {
            $this->signInLinksSnippetRenderer
                ->expects($this->once())
                ->method('render')
                ->with($this->model, $this->template);
            $this->metaTagsSnippetsRenderer
                ->expects($this->once())
                ->method('render')
                ->with($this->model, $this->template);
            $this->trackingSnippetRenderer
                ->expects($this->once())
                ->method('render')
                ->with($this->model, $this->template);
            $this->headerSnippetRenderer
                ->expects($this->once())
                ->method('render')
                ->with($this->model, $this->template);
            $this->appendCSRFTokenSnippetRenderer
                ->expects($this->once())
                ->method('render')
                ->with($this->model, $this->template);
            $this->infoBarRenderer
                ->expects($this->once())
                ->method('render')
                ->with($this->template);

            $this->genericPageRenderer->render($this->model, $this->template);
        }
    }
}
