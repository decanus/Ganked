<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{
    /**
     * @covers Ganked\Frontend\Controllers\SearchPageController
     * @covers \Ganked\Frontend\Controllers\AbstractPageController
     */
    class SearchPageControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SearchPageController
         */
        private $controller;
        private $renderer;
        private $model;
        private $searchHandler;
        private $request;
        private $cookie;
        private $response;
        private $fetchSessionCookieQuery;
        private $writeSessionCommand;
        private $storePreviousUriCommand;
        private $uri;
        private $isSessionStartedQuery;

        protected function setUp()
        {
            $this->renderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->cookie = $this->getMockBuilder(\Ganked\Library\ValueObjects\Cookie::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\SearchPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->searchHandler = $this->getMockBuilder(\Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
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

            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->isSessionStartedQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\IsSessionStartedQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new SearchPageController(
                $this->response,
                $this->fetchSessionCookieQuery,
                $this->renderer,
                $this->model,
                $this->writeSessionCommand,
                $this->storePreviousUriCommand,
                $this->isSessionStartedQuery,
                $this->searchHandler
            );
        }

        public function testExecuteWorks()
        {
            $this->model
                ->expects($this->once())
                ->method('getResponseCode')
                ->will($this->returnValue(200));

            $this->searchHandler
                ->expects($this->once())
                ->method('run')
                ->with($this->model);

            $path = '/';
            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->renderer
                ->expects($this->once())
                ->method('render')
                ->with($this->model)
                ->will($this->returnValue('test'));

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
