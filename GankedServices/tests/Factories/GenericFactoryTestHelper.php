<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\Factories
{

    use Ganked\Skeleton\Factories\MasterFactory;

    abstract class GenericFactoryTestHelper extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var MasterFactory
         */
        private $masterFactory;

        private $configuration;

        protected function setUp()
        {
            $this->configuration = $this->getMockBuilder(\Ganked\Skeleton\Configuration::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->configuration->expects($this->any())->method('get')->will($this->returnValue('test'));

            $this->masterFactory = new MasterFactory($this->configuration);
            $this->masterFactory->addFactory(new \Ganked\Services\Factories\BackendFactory);
            $this->masterFactory->addFactory(new \Ganked\Services\Factories\RouterFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);
            $this->masterFactory->addFactory(new \Ganked\Services\Factories\ControllerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $this->masterFactory->addFactory(new ServiceClientFactory);

        }

        /**
         * @return MasterFactory
         */
        protected function getMasterFactory()
        {
            return $this->masterFactory;
        }

        /**
         * @param $method
         * @param $instance
         * @param array $args
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
