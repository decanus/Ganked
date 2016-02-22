<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Commands
{

    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Session\Session;

    class DestroySessionCommand
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
         * @param AbstractRequest $request
         */
        public function execute(AbstractRequest $request)
        {
            $this->session->destroy($request);
        }
    }
}
