<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
// @codeCoverageIgnoreStart
namespace Ganked\Library\Logging
{

    use Ganked\Library\Logging\Loggers\LoggerInterface;
    use Ganked\Library\Logging\Logs\CriticalExceptionLog;
    use Ganked\Library\Logging\Logs\EmergencyExceptionLog;
    use Ganked\Library\Logging\Logs\LogInterface;

    trait LogProvider
    {
        /**
         * @var LoggerInterface
         */
        private $logger;

        /**
         * @param LoggerInterface $logger
         */
        public function setLogger(LoggerInterface $logger)
        {
            $this->logger = $logger;
        }

        /**
         * @return LoggerInterface
         */
        public function getLogger()
        {
            return $this->logger;
        }

        /**
         * @param \Exception $e
         *
         * @throws \RuntimeException
         */
        public function logCriticalException(\Exception $e)
        {
            $this->log(new CriticalExceptionLog($e));
        }

        /**
         * @param \Exception $e
         *
         * @throws \RuntimeException
         */
        public function logEmergencyException(\Exception $e)
        {
            $this->log(new EmergencyExceptionLog($e));
        }

        /**
         * @param LogInterface $log
         *
         * @throws \RuntimeException
         */
        private function log(LogInterface $log)
        {
            $logger = $this->getLogger();

            if ($logger === null) {
                throw new \RuntimeException('No Logger set');
            }

            $logger->log($log);
        }
    }
}
// @codeCoverageIgnoreEnd
