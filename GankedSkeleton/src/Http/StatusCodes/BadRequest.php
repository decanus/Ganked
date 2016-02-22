<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class BadRequest implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '400';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 400 Bad Request';
        }
    }
}
