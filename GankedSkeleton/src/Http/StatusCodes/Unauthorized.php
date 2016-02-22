<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class Unauthorized implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '401';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 401 Unauthorized';
        }
    }
}
