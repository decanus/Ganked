<?php

namespace Ganked\Skeleton\Factories
{

    use Ganked\Library\Backends\FileBackend;

    /**
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     */
    class MasterFactoryTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var MasterFactory
         */
        private $factory;
        private $routerFactory;

        private $configuration;

        protected function setUp()
        {
            $this->configuration = $this->getMockBuilder(\Ganked\Skeleton\Configuration::class)->disableOriginalConstructor()->getMock();

            $this->factory = new MasterFactory($this->configuration);
            $this->routerFactory = new BackendFactory();
        }

        public function testGetConfigurationWorks()
        {
            $this->assertSame($this->configuration, $this->factory->getConfiguration());
        }

        public function testCallWithInvalidMethodThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->factory->createTest();
        }

        public function testAddFactoryWorks()
        {
            $this->factory->addFactory($this->routerFactory);
            $this->assertInstanceOf(FileBackend::class, $this->factory->createFileBackend());
        }
    }
}
