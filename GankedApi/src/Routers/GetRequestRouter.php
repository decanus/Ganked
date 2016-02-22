<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{

    use Ganked\API\Controllers\AbstractApiController;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\MongoCursorModel;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\Request\GetRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class GetRequestRouter extends AbstractRouter
    {

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            if (!$request instanceof GetRequest) {
                return;
            }

            $uri = $request->getUri();
            $path = $uri->getPath();

            $controller = $this->routeFavouritesPaths($uri);
            if ($controller instanceof AbstractApiController) {
                return $controller;
            }

            $controller = $this->routeUsersPaths($uri);
            if ($controller instanceof AbstractApiController) {
                return $controller;
            }

            $controller = $this->routeAccountPaths($uri);
            if ($controller instanceof AbstractApiController) {
                return $controller;
            }

            if (preg_match('#^/posts/([a-fA-f0-9]{24})$#', $path)) {
                return $this->getFactory()->createGetPostController(new ApiModel($uri));
            }

            return $this->getFactory()->createErrorController();
        }

        /**
         * @param Uri $uri
         */
        private function routeAccountPaths(Uri $uri)
        {
            $paths = $uri->getExplodedPath();

            if ($paths[0] !== 'accounts' || !isset($paths[1]) || !count($paths) >= 2) {
                return;
            }

            if (!$this->isMongoId($paths[1]) && !$this->isEmail($paths[1]) && !$this->isUsername($paths[1])) {
                return;
            }

            if (!isset($paths[2])) {
                return $this->getFactory()->createGetAccountController(new ApiModel($uri));
            }
        }

        /**
         * @param Uri $uri
         */
        private function routeUsersPaths(Uri $uri)
        {
            $paths = $uri->getExplodedPath();

            if ($paths[0] !== 'users' || !isset($paths[1]) || !count($paths) >= 2) {
                return;
            }

            if (!$this->isMongoId($paths[1]) && !$this->isSteamId($paths[1]) && !$this->isUsername($paths[1])) {
                return;
            }

            if (isset($paths[2]) && $paths[2] === 'posts' && $this->isMongoId($paths[1])) {
                return $this->getFactory()->createGetUserPostsController(new ApiModel($uri));
            }

            if (!isset($paths[2])) {
                return $this->getFactory()->createGetUserController(new ApiModel($uri));
            }
        }

        /**
         * @param Uri $uri
         */
        private function routeFavouritesPaths(Uri $uri)
        {
            $path = $uri->getExplodedPath();

            if ($path[0] !== 'favourites') {
                return;
            }

            if (!$this->isMongoId($path[1])) {
                return;
            }

            if (!isset($path[2])) {
                return;
            }

            if ($path[2] === 'summoners' && !isset($path[3])) {
                return $this->getFactory()->createGetFavouriteSummonerController(new ApiModel($uri));
            }

            if ($path[2] === 'summoners' && isset($path[3]) && $path[3] === 'show') {
                return $this->getFactory()->createGetFavouriteSummonerRelationshipController(new MongoCursorModel($uri));
            }
        }

        /**
         * @param string $username
         *
         * @return bool
         */
        private function isUsername($username)
        {
            try {
                new Username($username);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $steamId
         *
         * @return bool
         */
        private function isSteamId($steamId)
        {
            try {
                new SteamId($steamId);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        private function isMongoId($id)
        {
            try {
                new \MongoId($id);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $email
         *
         * @return bool
         */
        private function isEmail($email)
        {
            try {
                new Email($email);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }
    }
}
