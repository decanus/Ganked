<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\FirstName;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Library\ValueObjects\LastName;
    use Ganked\Library\ValueObjects\Password;
    use Ganked\Library\ValueObjects\Salt;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Post\Commands\InsertUserCommand;
    use Ganked\Post\Mails\VerifyMail;
    use Ganked\Post\Queries\IsVerifiedForBetaQuery;
    use Ganked\Skeleton\Queries\FetchAccountQuery;
    use Ganked\Skeleton\Session\Session;

    class RegistrationRequestHandler extends AbstractRequestHandler implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var InsertUserCommand
         */
        private $insertUserCommand;

        /**
         * @var IsVerifiedForBetaQuery
         */
        private $isVerifiedForBetaQuery;

        /**
         * @var Email
         */
        private $email;

        /**
         * @var Password
         */
        private $password;

        /**
         * @var Username
         */
        private $username;

        /**
         * @var FirstName
         */
        private $firstName;

        /**
         * @var LastName
         */
        private $lastName;

        /**
         * @var VerifyMail
         */
        private $mail;

        /**
         * @var FetchAccountQuery
         */
        private $fetchAccountQuery;

        /**
         * @param Session                $session
         * @param FetchAccountQuery      $fetchAccountQuery
         * @param InsertUserCommand      $insertUserCommand
         * @param VerifyMail             $verifyMail
         * @param IsVerifiedForBetaQuery $isVerifiedForBetaQuery
         */
        public function __construct(
            Session $session,
            FetchAccountQuery $fetchAccountQuery,
            InsertUserCommand $insertUserCommand,
            VerifyMail $verifyMail,
            IsVerifiedForBetaQuery $isVerifiedForBetaQuery
        )
        {
            parent::__construct($session);
            $this->insertUserCommand = $insertUserCommand;
            $this->mail = $verifyMail;
            $this->isVerifiedForBetaQuery = $isVerifiedForBetaQuery;
            $this->fetchAccountQuery = $fetchAccountQuery;
        }

        protected function validateForm()
        {
            $this->checkCSRFToken();
            $request = $this->getRequest();

            try {
                $this->email = new Email($request->getParameter('email'));
            } catch (\Exception $e) {
                $this->setError('email', 'Please enter a valid Email');
                return;
            }

            if (!$this->isVerifiedForBetaQuery->execute($this->email)) {
                $this->setError('email', 'This email is not approved for the beta program');
                return;
            }

            if (!isset($this->fetchAccountQuery->execute($this->email)['errors'])) {
                $this->setError('email', 'Email is already in use');
                return;
            }

            try {
                $this->username = new Username($request->getParameter('username'));
            } catch (\InvalidArgumentException $e) {
                $this->setError('username', 'Please ensure username only contains letters and numbers');
                return;
            }

            if (!isset($this->fetchAccountQuery->execute($this->username)['errors'])) {
                $this->setError('username', 'Username is already in use');
                return;
            }

            try {
                $this->firstName = new FirstName($request->getParameter('firstName'));
            } catch (\InvalidArgumentException $e) {
                $this->setError('firstName', 'Please enter a valid firstname');
            }

            try {
                $this->lastName = new LastName($request->getParameter('lastName'));
            } catch (\InvalidArgumentException $e) {
                $this->setError('lastName', 'Please enter a valid lastname');
            }

            try {
                $this->password = new Password($request->getParameter('password'));
            } catch (\InvalidArgumentException $e) {
                $this->setError('password', 'Password must contain 6 characters');
                return;
            }

        }

        protected function performAction()
        {
            $salt = new Salt();
            $hash = new Hash((string) $this->password, (string) $salt);
            $request = $this->getRequest();
            $verificationHash = md5($request->getUserIP() . time() . $request->getUserAgent());

            $this->insertUserCommand->execute(
                $this->firstName,
                $this->lastName,
                $this->username,
                $hash,
                $salt,
                $this->email,
                $verificationHash
            );

            $this->mail->setHash($verificationHash);
            $this->mail->setRecipient(['email' => (string) $this->email, 'name' =>  $this->firstName . ' ' . $this->lastName]);

            try {
                $this->mail->send();
            } catch (\Exception $e) {
                $this->logEmergencyException($e);
                $this->setErrorMessage('Failed to send verification mail, please try again later');
                return;
            }

            $this->setSuccessMessage('Successfully registered, verification mail has been sent to ' . (string) $this->email);
        }
    }
}
