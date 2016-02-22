<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Logging
{

    use Ganked\Library\Logging\Loggers\AbstractLogger;
    use Ganked\Library\Logging\Loggers\LoggerInterface;
    use Ganked\Library\Logging\Logs\LogInterface;

    class Logger implements LoggerInterface
    {
        /**
         * @var AbstractLogger[]
         */
        private $loggers = [];

        /**
         * @param AbstractLogger $logger
         */
        public function addLogger(AbstractLogger $logger)
        {
            $this->loggers[] = $logger;
        }

        /**
         * @param LogInterface $log
         */
        public function log(LogInterface $log)
        {
            foreach ($this->loggers as $logger) {
                if (!$logger->handles($log)) {
                    continue;
                }

                $logger->log($log);
            }
        }
    }
}
