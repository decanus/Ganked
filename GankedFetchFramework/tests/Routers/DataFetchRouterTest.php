<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Routers
{

    use Ganked\Skeleton\Configuration;
    use Ganked\Skeleton\Factories\MasterFactory;

    /**
     * @covers Ganked\Fetch\Routers\DataFetchRouter
     * @uses \Ganked\Fetch\Factories\QueryFactory
     * @uses \Ganked\Fetch\Factories\ControllerFactory
     * @uses \Ganked\Fetch\Factories\HandlerFactory
     * @uses \Ganked\Fetch\Factories\MapperFactory
     * @uses \Ganked\Fetch\Controllers\DataFetchController
     * @uses \Ganked\Fetch\Handlers\DataFetch\LandingPageStreamDataFetchHandler
     * @uses \Ganked\Fetch\Queries\FetchTwitchTopStreamsQuery
     * @uses \Ganked\Fetch\Handlers\DataFetch\LeagueOfLegendsMatchDataFetchHandler
     */
    class DataFetchRouterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var DataFetchRouter
         */
        private $router;
        private $request;
        private $uri;
        private $masterFactory;


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
            $this->masterFactory->addFactory(new \Ganked\Fetch\Factories\QueryFactory($sessionData));
            $this->masterFactory->addFactory(new \Ganked\Fetch\Factories\ControllerFactory());
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\BackendFactory());
            $this->masterFactory->addFactory(new \Ganked\Fetch\Factories\HandlerFactory());
            $this->masterFactory->addFactory(new \Ganked\Fetch\Factories\MapperFactory());
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory());
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory());
            $this->router = new DataFetchRouter($this->masterFactory);

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
        public function provideInstanceNames()
        {
            return [
                ['/fetch/getStream', \Ganked\Fetch\Controllers\DataFetchController::class],
                ['/fetch/match', \Ganked\Fetch\Controllers\DataFetchController::class],
            ];
        }
    }
}
