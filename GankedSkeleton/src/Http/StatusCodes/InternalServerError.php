<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class InternalServerError implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '500';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 500 Internal server error';
        }
    }
}
