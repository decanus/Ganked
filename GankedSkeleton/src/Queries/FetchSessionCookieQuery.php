<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{

    use Ganked\Skeleton\Session\Session;

    class FetchSessionCookieQuery
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
         * @return \Ganked\Library\ValueObjects\Cookie
         */
        public function execute()
        {
            return $this->session->getCookie();
        }
    }
}
