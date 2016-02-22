<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Logging\Loggers
{

    use Ganked\Library\Logging\Logs\LogInterface;

    class ErrorLogger extends AbstractLogger
    {

        /**
         * @return array
         */
        protected function getTypes()
        {
            return [
                \Ganked\Library\Logging\Logs\LogInterface::class
            ];
        }

        /**
         * @param LogInterface $log
         */
        public function log(LogInterface $log)
        {
            error_log($log->getMessage());
        }
    }
}
