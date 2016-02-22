<?php

namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Frontend\Routers\SteamLoginRouter
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     * @uses \Ganked\Frontend\Controllers\SteamRegistrationPageController
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Controllers\SteamLoginController
     * @uses \Ganked\Frontend\ParameterObjects\ControllerParameterObject
     * @uses \Ganked\Frontend\Controllers\AbstractPageController
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\Factories\ControllerFactory
     * @uses \Ganked\Frontend\Factories\RendererFactory
     * @uses \Ganked\Frontend\Factories\CommandFactory
     * @uses \Ganked\Frontend\Commands\SaveSteamIdInSessionCommand
     * @uses \Ganked\Frontend\Commands\LockSessionForSteamLoginCommand
     */
    class SteamLoginRouterTest extends GenericRouterTestHelper
    {
        private $sessionData;

        protected function setUp()
        {
            parent::setUp();
            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->router = new SteamLoginRouter(
                $this->masterFactory,
                $this->sessionData
            );
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @param $path
         * @param $instance
         * @dataProvider provideInstanceNames
         */
        public function testCreateRouteWorks($path, $instance)
        {
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will($this->returnValue($this->getMock(\Ganked\Library\DataObjects\Accounts\AnonymousAccount::class)));

            parent::testCreateRouteWorks($path, $instance);
        }

        public function testSteamLockedUserIsRedirected()
        {
            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $request
                ->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue($uri));

            $uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue('/login/steam'));

            $this->sessionData
                ->expects($this->once())
                ->method('isSteamLoginLocked')
                ->will($this->returnValue(true));

            $this->assertInstanceOf(\Ganked\Skeleton\Controllers\GetController::class, $this->router->route($request));
        }

        public function testLoggedInAccountIsRedirected()
        {
            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $request
                ->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue($uri));

            $uri
                ->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue('/login/steam'));
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will(
                    $this->returnValue(
                        $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\RegisteredAccount::class)->disableOriginalConstructor()->getMock()
                    )
                );

            $this->assertInstanceOf(\Ganked\Skeleton\Controllers\GetController::class, $this->router->route($request));
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/register/steam', \Ganked\Frontend\Controllers\SteamRegistrationPageController::class],
                ['/login/steam', \Ganked\Frontend\Controllers\SteamLoginController::class],
            ];
        }
    }
}
