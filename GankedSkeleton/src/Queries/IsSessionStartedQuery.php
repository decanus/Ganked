<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Skeleton\Session\Session;

    class IsSessionStartedQuery
    {
        /**
         * @var Session
         */
        private $session;

        /**
         * @param Session $session
         */
        public function __construct(Session $session)
        {
            $this->session = $session;
        }

        /**
         * @return bool
         */
        public function execute()
        {
            return $this->session->isSessionStarted();
        }
   
    }
}
