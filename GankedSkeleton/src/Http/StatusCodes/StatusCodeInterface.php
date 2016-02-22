<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{
    interface StatusCodeInterface
    {
        /**
         * @return string
         */
        public function __toString();

        /**
         * @return string
         */
        public function getHeaderString();
    }
}
