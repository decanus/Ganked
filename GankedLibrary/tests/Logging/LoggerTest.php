<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Library\Logging
{

    /**
     * @covers Ganked\Library\Logging\Logger
     */
    class LoggerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Logger
         */
        private $logger;
        private $slackLogger;

        protected function setUp()
        {
            $this->slackLogger = $this->getMockBuilder(\Ganked\Library\Logging\Loggers\SlackLogger::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->logger = new Logger();
            $this->logger->addLogger($this->slackLogger);
        }

        public function testLogIsLoggedByTheCorrectLogger()
        {
            $log = $this->getMockBuilder(\Ganked\Library\Logging\Logs\LogInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->slackLogger
                ->expects($this->at(0))
                ->method('handles')
                ->with($log)
                ->will($this->returnValue(false));

            $this->slackLogger
                ->expects($this->at(1))
                ->method('handles')
                ->with($log)
                ->will($this->returnValue(true));

            $this->slackLogger
                ->expects($this->once())
                ->method('log')
                ->with($log);

            $this->logger->log($log);
            $this->logger->log($log);
        }
    }
}
