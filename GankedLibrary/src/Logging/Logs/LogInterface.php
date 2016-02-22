<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\Logging\Logs
{
    interface LogInterface 
    {
        /**
         * @return array
         */
        public function getLog();

        /**
         * @return string
         */
        public function getMessage();
    }
}
