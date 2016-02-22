<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Routers
{
    /**
     * @covers Ganked\Skeleton\Routers\Router
     */
    class RouterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Router
         */
        private $router;

        private $request;
        private $uri;

        protected function setUp()
        {
             $this->router = new Router();

            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        public function testNoRouteFoundThrowsException()
        {
            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/'));

            $this->setExpectedException(\Exception::class);
            $this->router->route($this->request);
        }

        public function testAddRouteAndRouteWorks()
        {
            $router = $this->getMockBuilder(RouterInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
            $controller = $this->getMockBuilder(\Ganked\Skeleton\Controllers\AbstractPageController::class)
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

            $this->router->addRoute($router);

            $router->expects($this->once())
                ->method('route')
                ->with($this->request)
                ->will($this->returnValue($controller));

            $this->router->route($this->request);
        }
    }
}
