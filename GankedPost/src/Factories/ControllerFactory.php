<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Post\Factories
{

    use Ganked\Skeleton\Http\Response\JsonResponse;

    class ControllerFactory extends \Ganked\Skeleton\Factories\ControllerFactory
    {
        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createRegistrationRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createRegistrationRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createLogoutRedirectController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createLogoutRedirectHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createLoginRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createLoginRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createVerificationRedirectController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createVerificationRedirectHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createResendVerificationMailRedirectController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createResendVerificationMailRedirectHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createCreateNewPostController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createCreateNewPostRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createForgotPasswordMailRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createForgotPasswordMailRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createPasswordRecoveryRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createPasswordRecoveryRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createSummonerFavouriteRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerFavouriteRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createSummonerUnfavouriteRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerUnfavouriteRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createSteamLoginRedirectController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSteamLoginRedirectHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createSteamRegistrationRequestController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSteamRegistrationRequestHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param \Ganked\Post\Models\JsonModel $model
         *
         * @return \Ganked\Post\Controllers\PostController
         */
        public function createSteamConnectRedirectController(\Ganked\Post\Models\JsonModel $model)
        {
            return new \Ganked\Post\Controllers\PostController(
                new JsonResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSteamConnectRedirectHandler(),
                $model,
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }


    }
}
