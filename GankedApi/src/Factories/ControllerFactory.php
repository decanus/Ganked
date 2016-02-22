<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\MongoCursorModel;
    use Ganked\Skeleton\Factories\AbstractFactory;
    use Ganked\Skeleton\Http\Response\JsonResponse;

    class ControllerFactory extends AbstractFactory
    {
        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createGetUserController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createGetUserQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createAddSteamAccountToUserController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\PostController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createAddSteamAccountToUserCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createGetUserPostsController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createGetUserPostsQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createGetPostController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createGetPostQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createLikePostController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createLikePostQueryHandler(),
                $this->getMasterFactory()->createLikePostCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createCreateNewPostController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCreateNewPostQueryHandler(),
                $this->getMasterFactory()->createCreateNewPostCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createTokenAuthorizationController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createTokenAuthorizationCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createFavouriteSummonerController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\PostController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createFavouriteSummonerCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\PostController
         */
        public function createUnfavouriteSummonerController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\PostController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createUnfavouriteSummonerCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createDeleteTokenController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createDeleteTokenCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createCreateNewUserController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createCreateNewUserCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createGetAccountController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createGetAccountQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createGetFavouriteSummonerController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createGetFavouriteSummonerQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetFavouriteSummonerResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createGetFavouriteSummonerRelationshipController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createGetFavouriteSummonerRelationshipQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetFavouriteSummonerRelationshipResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createUpdateUserController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\GetController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createUpdateUserQueryHandler(),
                $this->getMasterFactory()->createUpdateUserCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @param ApiModel $model
         *
         * @return \Ganked\API\Controllers\GetController
         */
        public function createAuthenticateUserController(ApiModel $model)
        {
            return new \Ganked\API\Controllers\PostController(
                new JsonResponse,
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createAuthenticateQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createResponseHandler()
            );
        }

        /**
         * @return \Ganked\API\Controllers\ErrorController
         */
        public function createErrorController()
        {
            return new \Ganked\API\Controllers\ErrorController(new JsonResponse);
        }
    }
}
