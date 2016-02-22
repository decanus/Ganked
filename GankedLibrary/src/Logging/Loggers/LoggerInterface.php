<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Logging\Loggers
{

    use Ganked\Library\Logging\Logs\LogInterface;

    interface LoggerInterface
    {
        /**
         * @param LogInterface $log
         */
        public function log(LogInterface $log);
    }
}
