<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Post\Commands\AuthenticationCommand;
    use Ganked\Post\Commands\LoginUserCommand;
    use Ganked\Skeleton\Queries\FetchUserByIdQuery;
    use Ganked\Skeleton\Session\Session;

    class LoginRequestHandler extends AbstractRequestHandler
    {
        /**
         * @var LoginUserCommand
         */
        private $loginUserCommand;

        /**
         * @var array
         */
        private $user;

        /**
         * @var AuthenticationCommand
         */
        private $authenticationCommand;

        /**
         * @var FetchUserByIdQuery
         */
        private $fetchUserByIdQuery;

        /**
         * @param Session               $session
         * @param LoginUserCommand      $loginUserCommand
         * @param AuthenticationCommand $authenticationCommand
         * @param FetchUserByIdQuery    $fetchUserByIdQuery
         */
        public function __construct(
            Session $session,
            LoginUserCommand $loginUserCommand,
            AuthenticationCommand $authenticationCommand,
            FetchUserByIdQuery $fetchUserByIdQuery
        )
        {
            parent::__construct($session);
            $this->loginUserCommand = $loginUserCommand;
            $this->authenticationCommand = $authenticationCommand;
            $this->fetchUserByIdQuery = $fetchUserByIdQuery;
        }

        protected function validateForm()
        {
            $this->checkCSRFToken();
            $request = $this->getRequest();

            $emailOrUsername = $request->getParameter('email');

            if (!$this->isLoggingInWithEmail($emailOrUsername) && !$this->isLoggingInWithUsername($emailOrUsername)) {
                $this->setError('email', 'Please enter a valid email or username');
                return;
            }

            try {
                $data = $this->authenticationCommand->execute($emailOrUsername, $request->getParameter('password'));

                if (!isset($data['data']['attributes']['user'])) {
                    throw new \Exception('Invalid login');
                }

                $user = $this->fetchUserByIdQuery->execute(new UserId($data['data']['attributes']['user']));

            } catch (\Exception $e) {
                $this->setError('password', 'Please enter valid login data');
                return;
            }

            try {

                if ($user->getResponseCode() !== 200) {
                    throw new \Exception('Unknown Error');
                }

                $this->user = $user->getDecodedJsonResponse()['data'];
            } catch (\Exception $e) {
                $this->setErrorMessage('Unknown error occurred, please try again later.');
                return;
            }

            if ($this->user['attributes']['verified'] === 0) {
                $this->setError(
                    'email',
                    'Please verify your account <a href="/account/resend-verification?email=' . $this->user['attributes']['email'] . '">Resend verification email</a>'
                );
                return;
            }
        }

        /**
         * @param string $email
         * @return bool
         */
        private function isLoggingInWithEmail($email)
        {
            try {
                new Email($email);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        /**
         * @param string $username
         * @return bool
         */
        private function isLoggingInWithUsername($username)
        {
            try {
                new Username($username);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        protected function performAction()
        {
            $this->loginUserCommand->execute(
                new Email($this->user['attributes']['email']),
                new Username($this->user['attributes']['username']),
                (string) $this->user['id']
            );

            //todo: fix for dev
            $this->setRedirect(new Uri('www.ganked.net'));

            if ($this->getSessionData()->hasPreviousUri()) {
                $this->setRedirect(new Uri($this->getSessionData()->getPreviousUri()));
            }

            $this->setSuccessMessage('Successfully logged in');
        }
    }
}
