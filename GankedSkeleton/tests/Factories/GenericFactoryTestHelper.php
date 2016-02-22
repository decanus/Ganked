<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    abstract class GenericFactoryTestHelper extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var MasterFactory
         */
        private $masterFactory;

        private $configuration;

        protected function setUp()
        {
            $this->configuration = $this->getMockBuilder(\Ganked\Skeleton\Configuration::class)->disableOriginalConstructor()->getMock();
            $this->configuration->expects($this->any())->method('get')->will($this->returnValue('test'));

            $this->masterFactory = new MasterFactory($this->configuration);

            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->masterFactory->addFactory(new BackendFactory);
            $this->masterFactory->addFactory(new SessionFactory($redisBackend));
            $this->masterFactory->addFactory(new QueryFactory($sessionData));
            $this->masterFactory->addFactory(new RouterFactory);
            $this->masterFactory->addFactory(new ControllerFactory);
            $this->masterFactory->addFactory(new CommandFactory($sessionData));
            $this->masterFactory->addFactory(new GatewayFactory);
            $this->masterFactory->addFactory(new LoggerFactory);
            $this->masterFactory->addFactory(new TransformationFactory);
            $this->masterFactory->addFactory(new RendererFactory);
            $this->masterFactory->addFactory(new ApplicationFactory);
        }

        /**
         * @param       $method
         * @param       $instance
         * @param array $args
         *
         * @throws \PHPUnit_Framework_Exception
         * @dataProvider provideInstanceNames
         */
        public function testCreateInstanceWorks($method, $instance, $args = [])
        {
            $this->assertInstanceOf($instance, call_user_func_array([$this->masterFactory, $method], $args));
        }

        /**
         * @return array
         */
        abstract public function provideInstanceNames();
    }
}
