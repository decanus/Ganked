<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Library\Logging\Loggers
{
    /**
     * @covers Ganked\Library\Logging\Loggers\SlackLogger
     * @covers Ganked\Library\Logging\Loggers\AbstractLogger
     */
    class SlackLoggerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SlackLogger
         */
        private $logger;
        private $gateway;
        private $emergencyLog;

        protected function setUp()
        {
            $this->gateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\SlackGateway::class)
                ->setMethods(['sendMessage'])
                ->disableOriginalConstructor()
                ->getMock();

            $this->logger = new SlackLogger($this->gateway);

            $this->emergencyLog = $this->getMockBuilder(\Ganked\Library\Logging\Logs\EmergencyExceptionLog::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        public function testHandlesReturnsTrueWhenLoggerHandlesType()
        {
            $this->assertTrue($this->logger->handles($this->emergencyLog));
        }

        public function testHandlesReturnsFalseWhenLoggerDoesNotHandleType()
        {
            $log = $this->getMockBuilder(\Ganked\Library\Logging\Logs\CriticalExceptionLog::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->assertFalse($this->logger->handles($log));
        }

        public function testLogWorks()
        {
            $log = [
                'level' => 'test',
                'message' => 'unittest',
                'trace' => 'i love 100% coverage'
            ];

            $this->emergencyLog
                ->expects($this->once())
                ->method('getLog')
                ->will($this->returnValue($log));

            $this->gateway
                ->expects($this->once())
                ->method('sendMessage');

            $this->logger->log($this->emergencyLog);
        }

    }
}
