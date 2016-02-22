<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class MovedPermanently implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '301';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 301 Moved Permanently';
        }
    }
}
