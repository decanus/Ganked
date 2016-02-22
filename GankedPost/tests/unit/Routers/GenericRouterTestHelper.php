<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Routers
{

    use Ganked\Skeleton\Configuration;
    use Ganked\Skeleton\Factories\MasterFactory;

    abstract class GenericRouterTestHelper extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var \Ganked\Skeleton\Factories\MasterFactory
         */
        protected $masterFactory;

        /**
         * @var \Ganked\Skeleton\Routers\AbstractRouter
         */
        protected $router;

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
            $config = $this->getMockBuilder(Configuration::class)
                ->disableOriginalConstructor()
                ->getMock();
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->masterFactory = new MasterFactory($config);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\SessionFactory($redisBackend));
            $this->masterFactory->addFactory(new \Ganked\Post\Factories\QueryFactory($sessionData));
            $this->masterFactory->addFactory(new \Ganked\Post\Factories\MailFactory);
            $this->masterFactory->addFactory(new \Ganked\Post\Factories\ControllerFactory);
            $this->masterFactory->addFactory(new \Ganked\Post\Factories\BackendFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $this->masterFactory->addFactory(new \Ganked\Post\Factories\HandlerFactory($sessionData));
            $this->masterFactory->addFactory(new \Ganked\Post\Factories\CommandFactory($sessionData));
        }

        /**
         * @param $path
         * @param $instance
         * @dataProvider provideInstanceNames
         */
        public function testCreateRouteWorks($path, $instance)
        {
            $this->request
                ->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue($this->uri));

            $this->uri
                ->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue($path));

            $this->assertInstanceOf($instance, $this->router->route($this->request));
        }

        /**
         * @return array
         */
        abstract public function provideInstanceNames();
    }
}
