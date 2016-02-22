<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\MetaTags;

    /**
     * @covers Ganked\Frontend\Controllers\StaticPageController
     * @covers Ganked\Frontend\Controllers\AbstractPageController
     */
    class StaticPageControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var StaticPageController
         */
        private $controller;

        private $dataPoolReader;
        private $renderer;
        private $model;
        private $request;
        private $uri;
        private $cookie;
        private $response;
        private $fetchSessionCookieQuery;
        private $writeSessionCommand;
        private $storePreviousUriCommand;
        private $isSessionStartedQuery;

        protected function setUp()
        {
            $this->renderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\StaticPageRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();;

            $this->cookie = $this->getMockBuilder(\Ganked\Library\ValueObjects\Cookie::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\StaticPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->dataPoolReader = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->response = $this->getMockBuilder(\Ganked\Skeleton\Http\Response\HtmlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fetchSessionCookieQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchSessionCookieQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->writeSessionCommand = $this->getMockBuilder(\Ganked\Skeleton\Commands\WriteSessionCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->storePreviousUriCommand = $this->getMockBuilder(\Ganked\Skeleton\Commands\StorePreviousUriCommand::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->isSessionStartedQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\IsSessionStartedQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new StaticPageController(
                $this->response,
                $this->fetchSessionCookieQuery,
                $this->renderer,
                $this->model,
                $this->writeSessionCommand,
                $this->storePreviousUriCommand,
                $this->isSessionStartedQuery,
                $this->dataPoolReader
            );
        }

        public function testExecuteWorks()
        {
            $this->model
                ->expects($this->once())
                ->method('getResponseCode')
                ->will($this->returnValue(200));

            $this->model
                ->expects($this->once())
                ->method('getRequestUri')
                ->will($this->returnValue($this->uri));

            $path = '/';
            $this->uri
                ->expects($this->exactly(2))
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->dataPoolReader
                ->expects($this->once())
                ->method('getStaticPageSnippet')
                ->with($path)
                ->will($this->returnValue(new DomHelper('<html></html>')));

            $this->dataPoolReader
                ->expects($this->once())
                ->method('getMetaTagsForStaticPage')
                ->with($path)
                ->will($this->returnValue(new MetaTags));

            $this->model
                ->expects($this->once())
                ->method('setMetaTags');

            $this->model
                ->expects($this->once())
                ->method('setTemplate');

            $this->isSessionStartedQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(false));

            $this->fetchSessionCookieQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue($this->cookie));

            $this->assertSame(
                $this->response,
                $this->controller->execute($this->request)
            );
        }
    }
}
