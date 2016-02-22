<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Logging\Loggers
{

    use Ganked\Library\Logging\Logs\LogInterface;

    abstract class AbstractLogger implements LoggerInterface
    {
        /**
         * @param LogInterface $log
         *
         * @return bool
         */
        public function handles(LogInterface $log)
        {
            foreach ($this->getTypes() as $type) {
                if ($log instanceof $type) {
                    return true;
                }
            }

            return false;
        }

        /**
         * @return array
         */
        abstract protected function getTypes();
    }
}
