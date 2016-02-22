<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;
    use Ganked\Skeleton\Configuration;
    use Ganked\Skeleton\Factories\MasterFactory;

    /**
     * @covers Ganked\Frontend\Routers\CounterStrikePageRouter
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\MapperFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses \Ganked\Frontend\Models\SteamUserPageModel
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses \Ganked\Frontend\Controllers\AbstractPageController
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     * @uses \Ganked\Frontend\Controllers\CounterStrikeUserPageController
     * @uses \Ganked\Frontend\Queries\ResolveVanityUrlQuery
     * @uses \Ganked\Frontend\Queries\FetchPlayerBansQuery
     * @uses \Ganked\Frontend\Renderers\CounterStrikeUserPageRenderer
     */
    class CounterStrikePageRouterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CounterStrikePageRouter
         */
        private $router;
        private $reader;
        private $masterFactory;
        private $sessionData;

        protected function setUp()
        {
            $config = $this->getMockBuilder(Configuration::class)->disableOriginalConstructor()->getMock();

            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->masterFactory = new MasterFactory($config);

            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\SessionFactory($redisBackend));
            $this->masterFactory->addFactory(new \Ganked\Frontend\Factories\QueryFactory($this->sessionData));
            $this->masterFactory->addFactory(new \Ganked\Frontend\Factories\ControllerFactory);
            $this->masterFactory->addFactory(new \Ganked\Frontend\Factories\RendererFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\BackendFactory);
            $this->masterFactory->addFactory(new \Ganked\Frontend\Factories\HandlerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $this->masterFactory->addFactory(new \Ganked\Frontend\Factories\MapperFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\TransformationFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\CommandFactory($this->sessionData));
            $this->reader = $this->getMockBuilder(\Ganked\Frontend\Readers\CounterStrikeReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->router = new CounterStrikePageRouter($this->masterFactory, $this->reader);
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        public function testRouteWorksForUser()
        {
            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $request->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue($uri));
            $uri->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue('/games/cs-go/users/test'));
            $uri->expects($this->any())
                ->method('getExplodedPath')
                ->will($this->returnValue(['games', 'cs-go', 'users', 'test']));
            $this->reader
                ->expects($this->any())
                ->method('hasSteamUserWithId')
                ->with('test')
                ->will($this->returnValue(true));
            $this->reader
                ->expects($this->any())
                ->method('hasSteamUserWithCustomId')
                ->with('test')
                ->will($this->returnValue(true));

            $this->assertInstanceOf(
                \Ganked\Frontend\Controllers\CounterStrikeUserPageController::class,
                $this->router->route($request)
            );
        }

    }
}
