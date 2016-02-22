<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Controllers
{
    /**
     * @covers Ganked\Post\Controllers\PostController
     */
    class PostControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var PostController
         */
        private $controller;

        private $session;
        private $handler;
        private $model;
        private $request;
        private $cookie;
        private $response;
        private $writeSessionCommand;
        private $fetchSessionCookieQuery;
        private $isSessionStartedQuery;

        protected function setUp()
        {
            $this->session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->cookie = $this->getMockBuilder(\Ganked\Library\ValueObjects\Cookie::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->handler = $this->getMockBuilder(\Ganked\Post\Handlers\HandlerInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Post\Models\JsonModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
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

            $this->isSessionStartedQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\IsSessionStartedQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new PostController(
                $this->response,
                $this->fetchSessionCookieQuery,
                $this->handler,
                $this->model,
                $this->writeSessionCommand,
                $this->isSessionStartedQuery
            );
        }

        public function testExecuteWorksWithNoRedirect()
        {
            $this->handler
                ->expects($this->once())
                ->method('execute')
                ->with($this->model, $this->request)
                ->will($this->returnValue('yay'));

            $this->model
                ->expects($this->once())
                ->method('hasRedirectUri')
                ->will($this->returnValue(false));

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

        public function testExecuteWorksWithRedirect()
        {
            $this->handler
                ->expects($this->once())
                ->method('execute')
                ->with($this->model, $this->request)
                ->will($this->returnValue('yay'));

            $this->model
                ->expects($this->once())
                ->method('hasRedirectUri')
                ->will($this->returnValue(true));

            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model
                ->expects($this->once())
                ->method('getRedirectUri')
                ->will($this->returnValue($uri));

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
