<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Commands
{

    use Ganked\Skeleton\Session\Session;

    class WriteSessionCommand
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

        public function execute()
        {
            $this->session->write();
        }
    }
}