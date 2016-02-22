<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
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
            $this->configuration = $this->getMockBuilder(\Ganked\Skeleton\Configuration::class)->disableOriginalConstructor()->getMock();
            $this->configuration->expects($this->any())->method('get')->will($this->returnValue('test'));

            $this->masterFactory = new MasterFactory($this->configuration);

            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\BuilderFactory);
            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\TaskFactory);
            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\BackendFactory);
            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\LocatorFactory);
            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\RendererFactory);
            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\WriterFactory);
            $this->masterFactory->addFactory(new \Ganked\Backend\Factories\MapperFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $this->masterFactory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);

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
