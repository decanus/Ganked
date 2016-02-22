<?php

namespace Ganked\Skeleton
{
    /**
     * @covers Ganked\Skeleton\Configuration
     */
    class ConfigurationTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Configuration
         */
        private $configuration;

        protected function setUp()
        {
            $this->configuration = new Configuration(__DIR__ . '/data/ConfigurationTest.ini');
        }

        public function testGetKeyWorks()
        {
            $this->assertSame('yo', $this->configuration->get('test'));
        }

        public function testGetNotExistingKeyThrowsException()
        {
            $this->setExpectedException(\Exception::class);
            $this->configuration->get('DoesNotExist');
        }

        public function testLoadThrowsExceptionWhenFileNotReadable()
        {
            $this->configuration = new Configuration(__DIR__ . '/fileDoesNotExist.ini');
            $this->setExpectedException(\Exception::class);
            $this->configuration->get('test');
        }

        public function testIsDevelopmentModeWorks()
        {
            $this->assertTrue($this->configuration->isDevelopmentMode());
        }
    }
}
