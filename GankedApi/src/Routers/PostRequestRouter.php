<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\ApiPostModel;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\Request\PostRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class PostRequestRouter extends AbstractRouter
    {

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            if (!$request instanceof PostRequest) {
                return;
            }

            $uri = $request->getUri();
            $path = $uri->getPath();

            if (preg_match('#^/posts/([a-fA-f0-9]{24})/likes$#', $path)) {
                return $this->getFactory()->createLikePostController(new ApiPostModel($uri));
            }

            if (preg_match('#^/favourites/([a-fA-f0-9]{24})/summoners$#', $path)) {
                return $this->getFactory()->createFavouriteSummonerController(new ApiPostModel($uri));
            }

            switch ($path) {
                case '/posts':
                    return $this->getFactory()->createCreateNewPostController(new ApiPostModel($uri));
                case '/token':
                    return $this->getFactory()->createTokenAuthorizationController(new ApiPostModel($uri));
                case '/users':
                    return $this->getFactory()->createCreateNewUserController(new ApiModel($uri));
                case '/authenticate':
                    return $this->getFactory()->createAuthenticateUserController(new ApiModel($uri));

            }

            $explodedPath = $uri->getExplodedPath();

            if (isset($explodedPath[2]) && $explodedPath[0] === 'users' && $this->isMongoId($explodedPath[1]) && $explodedPath[2] === 'steamId') {
                return $this->getFactory()->createAddSteamAccountToUserController(new ApiModel($uri));
            }

            return $this->getFactory()->createErrorController();
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
    }
}
