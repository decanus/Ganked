<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Session\SessionData;

    class FetchPreviousUriQuery
    {
        /**
         * @var SessionData
         */
        private $data;

        /**
         * @param SessionData $data
         */
        public function __construct(SessionData $data)
        {
            $this->data = $data;
        }

        /**
         * @param Uri $requestUri
         *
         * @return string
         */
        public function execute(Uri $requestUri)
        {
            if ($this->data->hasPreviousUri()) {
                return $this->data->getPreviousUri();
            }

            return (string) $requestUri;
        }
    }
}
