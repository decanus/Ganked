<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\ParameterObjects
{

    use Ganked\Library\ValueObjects\Uri;

    abstract class AbstractControllerParameterObject
    {
        /**
         * @var Uri
         */
        private $uri;

        /**
         * @param Uri $uri
         */
        public function __construct(Uri $uri)
        {
            $this->uri = $uri;
        }

        /**
         * @return Uri
         */
        public function getUri()
        {
            return $this->uri;
        }
    }
}
