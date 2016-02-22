<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{

    use Ganked\Skeleton\Session\SessionData;

    class CommandFactory extends AbstractFactory
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
         * @return SessionData
         */
        protected function getSessionData()
        {
            return $this->sessionData;
        }

        /**
         * @return \Ganked\Skeleton\Commands\WriteSessionCommand
         */
        public function createWriteSessionCommand()
        {
            return new \Ganked\Skeleton\Commands\WriteSessionCommand(
                $this->getMasterFactory()->createSession()
            );
        }

        /**
         * @return \Ganked\Skeleton\Commands\StorePreviousUriCommand
         */
        public function createStorePreviousUriCommand()
        {
            return new \Ganked\Skeleton\Commands\StorePreviousUriCommand(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Skeleton\Commands\DestroySessionCommand
         */
        public function createDestroySessionCommand()
        {
            return new \Ganked\Skeleton\Commands\DestroySessionCommand(
                $this->getMasterFactory()->createSession()
            );
        }
    }
}