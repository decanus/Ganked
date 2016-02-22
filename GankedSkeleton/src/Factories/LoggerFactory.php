<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    class LoggerFactory extends AbstractFactory
    {
        /**
         * @var \Ganked\Library\Logging\Logger
         */
        private $logger;

        /**
         * @return \Ganked\Library\Logging\Logger
         */
        public function createLogger()
        {
            if ($this->logger === null) {
                $this->logger = new \Ganked\Library\Logging\Logger();
            }

            return $this->logger;
        }

        /**
         * @return \Ganked\Library\Logging\Logger
         */
        public function createLoggers()
        {
            $logger = $this->createLogger();

            $logger->addLogger($this->createSlackLogger());
            $logger->addLogger($this->createErrorLogger());

            return $logger;
        }

        /**
         * @return \Ganked\Library\Logging\Loggers\ErrorLogger
         */
        public function createErrorLogger()
        {
            return new \Ganked\Library\Logging\Loggers\ErrorLogger();
        }

        /**
         * @return \Ganked\Library\Logging\Loggers\SlackLogger
         */
        public function createSlackLogger()
        {
            return new  \Ganked\Library\Logging\Loggers\SlackLogger(
                $this->getMasterFactory()->createSlackGateway()
            );
        }
    }
}
