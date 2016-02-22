<?php
/**
* Copyright (c) Ganked 2015
* All rights reserved.
*/
namespace Ganked\Post\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;
    use Ganked\Skeleton\Session\SessionData;

    class HandlerFactory extends AbstractFactory
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
         * @return \Ganked\Post\Handlers\Request\LoginRequestHandler
         */
        public function createLoginRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\LoginRequestHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createLoginUserCommand(),
                $this->getMasterFactory()->createAuthenticationCommand(),
                $this->getMasterFactory()->createFetchUserByIdQuery()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\RegistrationRequestHandler
         */
        public function createRegistrationRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\RegistrationRequestHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createFetchAccountQuery(),
                $this->getMasterFactory()->createInsertUserCommand(),
                $this->getMasterFactory()->createVerifyMail(),
                $this->getMasterFactory()->createIsVerifiedForBetaQuery()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Redirect\LogoutRedirectHandler
         */
        public function createLogoutRedirectHandler()
        {
            return new \Ganked\Post\Handlers\Redirect\LogoutRedirectHandler(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->sessionData,
                $this->getMasterFactory()->createDestroySessionCommand()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler
         */
        public function createResendVerificationMailRedirectHandler()
        {
            return new \Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->getMasterFactory()->createFetchAccountQuery(),
                $this->getMasterFactory()->createVerifyMail()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Redirect\VerificationRedirectHandler
         */
        public function createVerificationRedirectHandler()
        {
            return new \Ganked\Post\Handlers\Redirect\VerificationRedirectHandler(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->getMasterFactory()->createVerifyUserCommand(),
                $this->getMasterFactory()->createFetchUserHashQuery(),
                $this->getMasterFactory()->createUpdateUserHashCommand()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\CreateNewPostRequestHandler
         */
        public function createCreateNewPostRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\CreateNewPostRequestHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createCreateNewPostCommand(),
                $this->getMasterFactory()->createSessionHasUserQuery()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\ForgotPasswordMailRequestHandler
         */
        public function createForgotPasswordMailRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\ForgotPasswordMailRequestHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createFetchUserHashQuery(),
                $this->getMasterFactory()->createFetchAccountQuery(),
                $this->getMasterFactory()->createForgotPasswordMail()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\PasswordRecoveryRequestHandler
         */
        public function createPasswordRecoveryRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\PasswordRecoveryRequestHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createFetchUserHashQuery(),
                $this->getMasterFactory()->createUpdateUserHashCommand(),
                $this->getMasterFactory()->createUpdateUserPasswordCommand(),
                $this->getMasterFactory()->createFetchAccountQuery()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\SummonerFavouriteHandler
         */
        public function createSummonerFavouriteRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\SummonerFavouriteHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createFavouriteSummonerCommand()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\SummonerUnfavouriteHandler
         */
        public function createSummonerUnfavouriteRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\SummonerUnfavouriteHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createUnfavouriteSummonerCommand()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Redirect\SteamLoginRedirectHandler
         */
        public function createSteamLoginRedirectHandler()
        {
            return new \Ganked\Post\Handlers\Redirect\SteamLoginRedirectHandler(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->getMasterFactory()->createFetchSteamIdFromSessionQuery(),
                $this->getMasterFactory()->createUnlockSessionFromSteamLoginCommand(),
                $this->getMasterFactory()->createLoginUserCommand(),
                $this->getMasterFactory()->createFetchUserWithSteamIdQuery(),
                $this->getMasterFactory()->createFetchPreviousUriQuery(),
                $this->getMasterFactory()->createRemoveSteamIdFromSessionCommand()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Request\SteamRegistrationRequestHandler
         */
        public function createSteamRegistrationRequestHandler()
        {
            return new \Ganked\Post\Handlers\Request\SteamRegistrationRequestHandler(
                $this->getMasterFactory()->createSession(),
                $this->getMasterFactory()->createFetchAccountQuery(),
                $this->getMasterFactory()->createInsertSteamUserCommand(),
                $this->getMasterFactory()->createVerifyMail(),
                $this->getMasterFactory()->createFetchSteamIdFromSessionQuery(),
                $this->getMasterFactory()->createUnlockSessionFromSteamLoginCommand(),
                $this->getMasterFactory()->createFetchUserWithSteamIdQuery(),
                $this->getMasterFactory()->createIsVerifiedForBetaQuery()
            );
        }

        /**
         * @return \Ganked\Post\Handlers\Redirect\AddSteamAccountRedirectHandler
         */
        public function createSteamConnectRedirectHandler()
        {
            return new \Ganked\Post\Handlers\Redirect\AddSteamAccountRedirectHandler(
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode(),
                $this->getMasterFactory()->createFetchUserWithSteamIdQuery(),
                $this->getMasterFactory()->createFetchSteamIdFromSessionQuery(),
                $this->getMasterFactory()->createCounterStrikeGateway(),
                $this->getMasterFactory()->createFetchAccountFromSessionQuery(),
                $this->getMasterFactory()->createConnectSteamAccountToUserCommand(),
                $this->getMasterFactory()->createRemoveSteamIdFromSessionCommand()
            );
        }
    }
}
