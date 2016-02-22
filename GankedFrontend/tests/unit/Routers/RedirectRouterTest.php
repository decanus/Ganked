<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    /**
     * @covers Ganked\Frontend\Routers\RedirectRouter
     * @uses Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     */
    class RedirectRouterTest extends GenericRouterTestHelper
    {
        private $reader;

        protected function setUp()
        {
            parent::setUp();
            $this->reader = $this->getMockBuilder(\Ganked\Frontend\Readers\UrlRedirectReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->router = new RedirectRouter($this->masterFactory, $this->reader);
        }

        public function testRouteWorksWithReader()
        {
            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $path = '/foo';

            $request->expects($this->once())->method('getUri')->will($this->returnValue($uri));
            $uri->expects($this->once())->method('getPath')->will($this->returnValue($path));

            $this->reader
                ->expects($this->once())
                ->method('hasPermanentUrlRedirect')
                ->with($path)
                ->will($this->returnValue(true));

            $this->reader
                ->expects($this->once())
                ->method('getPermanentUrlRedirect')
                ->with($path)
                ->will($this->returnValue('/bar'));

            $this->assertInstanceOf(\Ganked\Skeleton\Controllers\GetController::class, $this->router->route($request));
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/account/verify', \Ganked\Skeleton\Controllers\GetController::class],
                ['/account/resend-verification', \Ganked\Skeleton\Controllers\GetController::class],
            ];
        }
    }
}
