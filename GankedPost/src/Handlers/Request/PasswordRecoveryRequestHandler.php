<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Library\ValueObjects\Password;
    use Ganked\Post\Commands\UpdateUserHashCommand;
    use Ganked\Post\Commands\UpdateUserPasswordCommand;
    use Ganked\Post\Queries\FetchUserByEmailQuery;
    use Ganked\Skeleton\Queries\FetchAccountQuery;
    use Ganked\Skeleton\Queries\FetchUserHashQuery;
    use Ganked\Skeleton\Session\Session;

    class PasswordRecoveryRequestHandler extends AbstractRequestHandler
    {
        /**
         * @var FetchUserHashQuery
         */
        private $fetchUserHashQuery;

        /**
         * @var UpdateUserHashCommand
         */
        private $updateUserHashCommand;

        /**
         * @var UpdateUserPasswordCommand
         */
        private $updateUserPasswordCommand;

        /**
         * @var FetchAccountQuery
         */
        private $fetchAccountQuery;

        /**
         * @var Email
         */
        private $email;

        /**
         * @var Password
         */
        private $password;

        /**
         * @param Session                   $session
         * @param FetchUserHashQuery        $fetchUserHashQuery
         * @param UpdateUserHashCommand     $updateUserHashCommand
         * @param UpdateUserPasswordCommand $updateUserPasswordCommand
         * @param FetchAccountQuery         $fetchAccountQuery
         */
        public function __construct(
            Session $session,
            FetchUserHashQuery $fetchUserHashQuery,
            UpdateUserHashCommand $updateUserHashCommand,
            UpdateUserPasswordCommand $updateUserPasswordCommand,
            FetchAccountQuery $fetchAccountQuery
        )
        {
            parent::__construct($session);
            $this->fetchUserHashQuery = $fetchUserHashQuery;
            $this->updateUserHashCommand = $updateUserHashCommand;
            $this->updateUserPasswordCommand = $updateUserPasswordCommand;
            $this->fetchAccountQuery = $fetchAccountQuery;
        }


        protected function validateForm()
        {
            $this->checkCSRFToken();
            $request = $this->getRequest();

            try {
                $this->email = new Email($request->getParameter('email'));
                $hash = $request->getParameter('hash');
            } catch (\Exception $e) {
                $this->setErrorMessage('It looks like you used an invalid link. Please request another email');
                return;
            }

            try {
                $this->password = new Password($request->getParameter('newPassword'));
            } catch (\InvalidArgumentException $e) {
                $this->setError('newPassword', 'Password must contain 6 characters');
                return;
            }

            try {

                if ($this->fetchUserHashQuery->execute($this->email) !== $hash) {
                    throw new \RuntimeException('Hashes do not match');
                }

            } catch (\Exception $e) {
                $this->setErrorMessage('Something went wrong, Please try again later');
                return;
            }
        }

        protected function performAction()
        {
            try {
                $user = $this->fetchAccountQuery->execute($this->email);
                $password = new Hash((string) $this->password , $user['data']['attributes']['salt']);

                $this->updateUserPasswordCommand->execute($password, $this->email);

                $request = $this->getRequest();

                $this->updateUserHashCommand->execute(
                    $this->email,
                    md5($request->getUserIP() . time() . $request->getUserAgent())
                );

            } catch (\Exception $e) {
                $this->setErrorMessage('Something went wrong, Please try again later');
                return;
            }

            $this->setSuccessMessage('Password has been changed, you can now login');

        }
    }
}
