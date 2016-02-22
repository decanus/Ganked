<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
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
        protected $request;
        private $uri;

        protected function setUp()
        {
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $config = $this->getMockBuilder(Configuration::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->masterFactory = new MasterFactory($config);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\ControllerFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\RouterFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\HandlerFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\ReaderFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\ServiceFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\QueryFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\BackendFactory);
            $this->masterFactory->addFactory(new \Ganked\API\Factories\CommandFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);

        }

        /**
         * @param $path
         * @param $instance
         *
         * @throws \PHPUnit_Framework_Exception
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
            $this->uri
                ->expects($this->any())
                ->method('getExplodedPath')
                ->will($this->returnValue(explode('/', ltrim($path, '/'))));

            $this->assertInstanceOf($instance, $this->router->route($this->request));
        }

        /**
         * @return array
         */
        abstract public function provideInstanceNames();
    }
}
