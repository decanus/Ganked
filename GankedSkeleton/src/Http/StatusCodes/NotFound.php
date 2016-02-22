<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class NotFound implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '404';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 404 Not Found';
        }
    }
}
