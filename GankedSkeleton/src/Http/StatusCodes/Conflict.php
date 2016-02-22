<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class Conflict implements StatusCodeInterface
    {

        /**
         * @return string
         */
        public function __toString()
        {
            return '409';
        }

        /**
         * @return string
         */
        public function getHeaderString()
        {
            return 'Status: 409 Conflict';
        }
    }
}
