<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class MovedTemporarily implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '302';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 302 Moved Temporarily';
        }
    }
}
