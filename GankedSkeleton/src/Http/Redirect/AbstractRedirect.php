<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\Redirect
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\StatusCodes\StatusCodeInterface;

    abstract class AbstractRedirect implements RedirectInterface
    {
        /**
         * @var Uri
         */
        private $uri;

        /**
         * @var StatusCodeInterface
         */
        private $statusCode;

        /**
         * @param Uri                 $uri
         * @param StatusCodeInterface $statusCode
         */
        public function __construct(Uri $uri, StatusCodeInterface $statusCode)
        {
            $this->uri = $uri;
            $this->statusCode = $statusCode;
        }

        /**
         * @return Uri
         */
        public function getUri()
        {
            return $this->uri;
        }

        /**
         * @return StatusCodeInterface
         */
        public function getStatusCode()
        {
            return $this->statusCode;
        }
    }
}
