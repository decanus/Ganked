<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\Redirect
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\StatusCodes\StatusCodeInterface;

    interface RedirectInterface
    {
        /**
         * @return Uri
         */
        public function getUri();

        /**
         * @return StatusCodeInterface
         */
        public function getStatusCode();
    }
}
