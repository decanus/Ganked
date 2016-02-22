<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Logging
{

    use Ganked\Library\Logging\Loggers\LoggerInterface;

    interface LoggerAware
    {
        /**
         * @param LoggerInterface $logger
         */
        public function setLogger(LoggerInterface $logger);

        /**
         * @return LoggerInterface
         */
        public function getLogger();

    }
}
