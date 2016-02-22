<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Commands\DestroySessionCommand;
    use Ganked\Skeleton\Session\SessionData;

    class LogoutRedirectHandler extends AbstractRedirectHandler
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @var DestroySessionCommand
         */
        private $destroySessionCommand;

        /**
         * @param bool                  $isDevelopment
         * @param SessionData           $sessionData
         * @param DestroySessionCommand $destroySessionCommand
         */
        public function __construct(
            $isDevelopment = false,
            SessionData $sessionData,
            DestroySessionCommand $destroySessionCommand
        )
        {
            parent::__construct($isDevelopment);
            $this->sessionData = $sessionData;
            $this->destroySessionCommand = $destroySessionCommand;
        }

        /**
         * @return array
         * @throws \Exception
         * @throws \Ganked\Skeleton\Exceptions\MapException
         * @throws \RuntimeException
         */
        protected function doExecute()
        {
            // Don't catch invalid CSRF deserves a 500 error page
            if (!$this->sessionData->getToken()->check($this->getRequest()->getParameter('token'))) {
                throw new \RuntimeException('CSRF token does not match');
            }

            $this->sessionData->removeAccount();

            $this->destroySessionCommand->execute($this->getRequest());

            $model = $this->getModel();
            if ($this->sessionData->hasPreviousUri()) {
                $model->setRedirectUri(new Uri($this->sessionData->getPreviousUri()));
                return;
            }

            $model->setRedirectUri($this->redirectToPath());
        }
    }
}
