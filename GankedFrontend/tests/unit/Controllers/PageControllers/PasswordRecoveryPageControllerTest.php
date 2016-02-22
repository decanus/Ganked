<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{
    /**
     * @covers Ganked\Frontend\Controllers\PasswordRecoveryPageController
     * @covers \Ganked\Frontend\Controllers\AbstractPageController
     */
    class PasswordRecoveryPageControllerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var PasswordRecoveryPageController
         */
        private $controller;
        private $renderer;
        private $model;
        private $request;
        private $uri;
        private $response;
        private $fetchSessionCookieQuery;
        private $writeSessionCommand;
        private $storePreviousUriCommand;
        private $isSessionStartedQuery;
        private $fetchUserHashQuery;

        protected function setUp()
        {
            $this->renderer = $this->getMockBuilder(\Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\PasswordRecoveryPageModel::class)
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

            $this->fetchUserHashQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchUserHashQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->controller = new PasswordRecoveryPageController(
                $this->response,
                $this->fetchSessionCookieQuery,
                $this->renderer,
                $this->model,
                $this->writeSessionCommand,
                $this->storePreviousUriCommand,
                $this->isSessionStartedQuery,
                $this->fetchUserHashQuery
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
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('test@test.net'));

            $this->model
                ->expects($this->once())
                ->method('setEmail')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class));

            $hash = '123';
            $this->uri
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue($hash));

            $this->model
                ->expects($this->once())
                ->method('setHash')
                ->with($hash);

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue($hash));

            $this->model
                ->expects($this->once())
                ->method('hashIsValid');

            $this->isSessionStartedQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(true));

            $this->assertSame(
                $this->response,
                $this->controller->execute($this->request)
            );
        }

        public function testNonMatchingHashThrowsExceptionWorks()
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
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->at(1))
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('test@test.net'));

            $this->model
                ->expects($this->once())
                ->method('setEmail')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class));

            $hash = '123';
            $this->uri
                ->expects($this->at(2))
                ->method('getParameter')
                ->with('hash')
                ->will($this->returnValue('123'));

            $this->model
                ->expects($this->once())
                ->method('setHash')
                ->with($hash);

            $this->fetchUserHashQuery
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(\Ganked\Library\ValueObjects\Email::class))
                ->will($this->returnValue('1234'));

            $this->model
                ->expects($this->once())
                ->method('hashIsInvalid');

            $this->isSessionStartedQuery
                ->expects($this->once())
                ->method('execute')
                ->will($this->returnValue(true));

            $this->assertSame(
                $this->response,
                $this->controller->execute($this->request)
            );
        }
    }
}
