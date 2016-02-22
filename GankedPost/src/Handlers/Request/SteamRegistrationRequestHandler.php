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
    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Post\Commands\InsertSteamUserCommand;
    use Ganked\Post\Commands\UnlockSessionFromSteamLoginCommand;
    use Ganked\Post\Mails\VerifyMail;
    use Ganked\Post\Queries\IsVerifiedForBetaQuery;
    use Ganked\Skeleton\Queries\FetchAccountQuery;
    use Ganked\Skeleton\Queries\FetchSteamIdFromSessionQuery;
    use Ganked\Skeleton\Queries\FetchUserWithSteamIdQuery;
    use Ganked\Skeleton\Session\Session;

    class SteamRegistrationRequestHandler extends AbstractRequestHandler implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var InsertSteamUserCommand
         */
        private $insertSteamUserCommand;

        /**
         * @var IsVerifiedForBetaQuery
         */
        private $isVerifiedForBetaQuery;

        /**
         * @var Email
         */
        private $email;

        /**
         * @var Username
         */
        private $username;

        /**
         * @var VerifyMail
         */
        private $mail;

        /**
         * @var SteamId
         */
        private $steamId;

        /**
         * @var SteamCustomId
         */
        private $customId;

        /**
         * @var FetchAccountQuery
         */
        private $fetchAccountQuery;

        /**
         * @var FetchSteamIdFromSessionQuery
         */
        private $fetchSteamIdFromSessionQuery;

        /**
         * @var UnlockSessionFromSteamLoginCommand
         */
        private $unlockSessionFromSteamLoginCommand;

        /**
         * @var FetchUserWithSteamIdQuery
         */
        private $fetchUserWithSteamIdQuery;

        /**
         * @param Session                            $session
         * @param FetchAccountQuery                  $fetchAccountQuery
         * @param InsertSteamUserCommand             $insertSteamUserCommand
         * @param VerifyMail                         $verifyMail
         * @param FetchSteamIdFromSessionQuery       $fetchSteamIdFromSessionQuery
         * @param UnlockSessionFromSteamLoginCommand $unlockSessionFromSteamLoginCommand
         * @param FetchUserWithSteamIdQuery          $fetchUserWithSteamIdQuery
         * @param IsVerifiedForBetaQuery             $isVerifiedForBetaQuery
         */
        public function __construct(
            Session $session,
            FetchAccountQuery $fetchAccountQuery,
            InsertSteamUserCommand $insertSteamUserCommand,
            VerifyMail $verifyMail,
            FetchSteamIdFromSessionQuery $fetchSteamIdFromSessionQuery,
            UnlockSessionFromSteamLoginCommand $unlockSessionFromSteamLoginCommand,
            FetchUserWithSteamIdQuery $fetchUserWithSteamIdQuery,
            IsVerifiedForBetaQuery $isVerifiedForBetaQuery
        )
        {
            parent::__construct($session);
            $this->insertSteamUserCommand = $insertSteamUserCommand;
            $this->mail = $verifyMail;
            $this->isVerifiedForBetaQuery = $isVerifiedForBetaQuery;
            $this->fetchAccountQuery = $fetchAccountQuery;
            $this->fetchSteamIdFromSessionQuery = $fetchSteamIdFromSessionQuery;
            $this->unlockSessionFromSteamLoginCommand = $unlockSessionFromSteamLoginCommand;
            $this->fetchUserWithSteamIdQuery = $fetchUserWithSteamIdQuery;
        }

        protected function validateForm()
        {
            $this->checkCSRFToken();
            $request = $this->getRequest();

            $this->unlockSessionFromSteamLoginCommand->execute();

            try {
                $this->steamId = $this->fetchSteamIdFromSessionQuery->execute();
            } catch (\Exception $e) {
                $this->setErrorMessage('An unknown error occurred, please try again later');
                return;
            }

            if (!isset($this->fetchUserWithSteamIdQuery->execute($this->steamId)['errors'])) {
                $this->setErrorMessage('This steam account is already in use.');
                return;
            }

            try {
                $this->email = new Email($request->getParameter('email'));
            } catch (\Exception $e) {
                $this->setError('email', 'Please enter a valid Email');
                return;
            }

            try {
                $this->customId = new SteamCustomId($request->getParameter('customId'));
            } catch (\Exception $e) {
                $this->setErrorMessage('An unknown error occurred, please try again later');
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

        }

        protected function performAction()
        {
            $request = $this->getRequest();
            $verificationHash = md5($request->getUserIP() . time() . $request->getUserAgent());

            $this->insertSteamUserCommand->execute(
                $this->email,
                $this->username,
                $this->steamId,
                $verificationHash,
                (string) $this->customId
            );

            $this->mail->setHash($verificationHash);
            $this->mail->setRecipient(['email' => (string) $this->email, 'name' => (string) $this->username]);

            try {
                $this->mail->send();
            } catch (\Exception $e) {
                $this->logEmergencyException($e);
                $this->setErrorMessage('Failed to send verification mail, please try again later');
                return;
            }

            $this->setRedirect(new Uri('https://' . $this->getRequest()->getHost() . '/action/login/steam'));
        }
    }
}
