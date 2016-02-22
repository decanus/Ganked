<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{

    use Ganked\Skeleton\Factories\ApplicationFactory;
    use Ganked\Skeleton\Factories\GatewayFactory;
    use Ganked\Skeleton\Factories\LoggerFactory;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Factories\SessionFactory;

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

            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->masterFactory = new MasterFactory($this->configuration);

            $this->masterFactory->addFactory(new BackendFactory);
            $this->masterFactory->addFactory(new CommandFactory($sessionData));
            $this->masterFactory->addFactory(new ControllerFactory);
            $this->masterFactory->addFactory(new QueryFactory($sessionData));
            $this->masterFactory->addFactory(new SessionFactory($redisBackend));
            $this->masterFactory->addFactory(new MailFactory);
            $this->masterFactory->addFactory(new HandlerFactory($sessionData));
            $this->masterFactory->addFactory(new GatewayFactory);
            $this->masterFactory->addFactory(new RouterFactory);
            $this->masterFactory->addFactory(new LoggerFactory);
            $this->masterFactory->addFactory(new ApplicationFactory);

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
