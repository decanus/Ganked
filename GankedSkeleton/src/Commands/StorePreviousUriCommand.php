<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Commands
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Session\SessionData;

    class StorePreviousUriCommand
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @param SessionData $sessionData
         */
        public function __construct(SessionData $sessionData)
        {
            $this->sessionData = $sessionData;
        }

        /**
         * @param Uri $uri
         */
        public function execute(Uri $uri)
        {
            if ($this->sessionData->hasPreviousUri()) {
                $this->sessionData->removePreviousUri();
            }

            $this->sessionData->setPreviousUri($uri);
        }

    }
}