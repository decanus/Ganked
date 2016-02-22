<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Post\Commands\UpdateUserHashCommand;
    use Ganked\Post\Commands\VerifyUserCommand;
    use Ganked\Skeleton\Queries\FetchUserHashQuery;

    class VerificationRedirectHandler extends AbstractRedirectHandler implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var VerifyUserCommand
         */
        private $verifyUserCommand;

        /**
         * @var FetchUserHashQuery
         */
        private $fetchUserHashQuery;

        /**
         * @var UpdateUserHashCommand
         */
        private $updateUserHashCommand;

        /**
         * @param bool                  $isDevelopment
         * @param VerifyUserCommand     $verifyUserCommand
         * @param FetchUserHashQuery    $fetchUserHashQuery
         * @param UpdateUserHashCommand $updateUserHashCommand
         */
        public function __construct(
            $isDevelopment = false,
            VerifyUserCommand $verifyUserCommand,
            FetchUserHashQuery $fetchUserHashQuery,
            UpdateUserHashCommand $updateUserHashCommand
        )
        {
            parent::__construct($isDevelopment);
            $this->verifyUserCommand = $verifyUserCommand;
            $this->fetchUserHashQuery = $fetchUserHashQuery;
            $this->updateUserHashCommand = $updateUserHashCommand;
        }


        /**
         * @return array
         */
        protected function doExecute()
        {

            $request = $this->getRequest();
            $model = $this->getModel();

            try {
                $email = new Email($request->getParameter('email'));

                $hash = $this->fetchUserHashQuery->execute($email);
                $requestHash = $request->getParameter('hash');

                if ($hash !== $requestHash) {
                    throw new \RuntimeException('Hash "' . $hash . '" and "' . $requestHash . '" do not match');
                }

                $this->verifyUserCommand->execute($email);

                $this->updateUserHashCommand->execute(
                    $email,
                    md5($request->getUserIP() . time() . $request->getUserAgent())
                );

                $model->setRedirectUri($this->redirectToPath('/verification/success'));
            } catch (\Exception $e) {
                $this->logCriticalException($e);
                $model->setRedirectUri($this->redirectToPath('/verification/error'));
            }
        }
    }
}
