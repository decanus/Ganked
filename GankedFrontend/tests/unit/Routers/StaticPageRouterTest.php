<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;
    use Ganked\Skeleton\Factories\MasterFactory;

    /**
     * @covers Ganked\Frontend\Routers\StaticPageRouter
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     * @uses \Ganked\Frontend\Factories\QueryFactory
     * @uses \Ganked\Frontend\Factories\LocatorFactory
     * @uses \Ganked\Skeleton\Factories\SessionFactory
     * @uses \Ganked\Frontend\Factories\ControllerFactory
     * @uses \Ganked\Frontend\Factories\RendererFactory
     * @uses \Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Frontend\Renderers\StaticPageRenderer
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses \Ganked\Frontend\Controllers\AbstractPageController
     * @uses \Ganked\Frontend\Controllers\StaticPageController
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\Locators\RendererLocator
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\ParameterObjects\ControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     */
    class StaticPageRouterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var StaticPageRouter
         */
        private $router;

        private $factory;
        private $dataPoolReader;
        private $sessionData;
        private $request;
        private $uri;

        protected function setUp()
        {
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->dataPoolReader = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $config = $this->getMockBuilder(\Ganked\Skeleton\Configuration::class)
                ->disableOriginalConstructor()
                ->getMock();
            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->factory = new MasterFactory($config);
            $this->factory->addFactory(new \Ganked\Frontend\Factories\ControllerFactory);
            $this->factory->addFactory(new \Ganked\Frontend\Factories\RendererFactory);
            $this->factory->addFactory(new \Ganked\Frontend\Factories\QueryFactory($this->sessionData));
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\BackendFactory);
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\TransformationFactory);
            $this->factory->addFactory(new \Ganked\Frontend\Factories\HandlerFactory);
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $this->factory->addFactory(new \Ganked\Frontend\Factories\LocatorFactory);
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory());
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\SessionFactory($redisBackend));
            $this->factory->addFactory(new \Ganked\Skeleton\Factories\CommandFactory($this->sessionData));
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
            $this->router = new StaticPageRouter($this->factory, $this->dataPoolReader, $this->sessionData);
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        public function testRouterWorks()
        {
            $path = '/';

            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->dataPoolReader
                ->expects($this->once())
                ->method('hasStaticPage')
                ->with($path)
                ->will($this->returnValue(true));

            $this->assertInstanceOf(
                \Ganked\Frontend\Controllers\StaticPageController::class,
                $this->router->route($this->request)
            );
        }

        public function testRouterWorksWhenPageRequiresOffline()
        {
            $path = '/login';

            $this->request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->once())
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->dataPoolReader
                ->expects($this->once())
                ->method('hasStaticPage')
                ->with($path)
                ->will($this->returnValue(true));

            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\RegisteredAccount::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will($this->returnValue($account));

            $this->assertInstanceOf(\Ganked\Skeleton\Controllers\GetController::class, $this->router->route($this->request));
        }
    }
}
