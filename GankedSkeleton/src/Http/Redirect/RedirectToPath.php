<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\Redirect
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\StatusCodes\StatusCodeInterface;

    class RedirectToPath extends AbstractRedirect
    {
        /**
         * @var string
         */
        private $path;

        /**
         * @param Uri                 $uri
         * @param StatusCodeInterface $statusCode
         * @param string              $path
         */
        public function __construct(Uri $uri, StatusCodeInterface $statusCode, $path)
        {
            parent::__construct($uri, $statusCode);
            $this->path = $path;
        }

        /**
         * @return Uri
         */
        public function getUri()
        {
            return new Uri('http://' . parent::getUri()->getHost() . $this->path);
        }
    }
}
