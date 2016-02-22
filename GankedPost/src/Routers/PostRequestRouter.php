<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Routers
{

    use Ganked\Post\Models\JsonModel;
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
            $uri = $request->getUri();

            switch ($uri->getPath()) {
                case '/action/verify':
                    return $this->getFactory()->createVerificationRedirectController(new JsonModel($uri));
                //todo: move to form in markup so this can be a post request
                case '/action/resend-verification':
                    return $this->getFactory()->createResendVerificationMailRedirectController(new JsonModel($uri));
                case '/action/login/steam':
                    return $this->getFactory()->createSteamLoginRedirectController(new JsonModel($uri));
                case '/action/connect/steam':
                    return $this->getFactory()->createSteamConnectRedirectController(new JsonModel($uri));
            }

            if (!$request instanceof PostRequest) {
                return;
            }

            switch ($uri->getPath()) {
                case '/action/login':
                    return $this->getFactory()->createLoginRequestController(new JsonModel($uri));
                case '/action/register':
                    return $this->getFactory()->createRegistrationRequestController(new JsonModel($uri));
                case '/action/forgot-password':
                    return $this->getFactory()->createForgotPasswordMailRequestController(new JsonModel($uri));
                case '/action/logout':
                    return $this->getFactory()->createLogoutRedirectController(new JsonModel($uri));
                case '/action/post/create':
                    return $this->getFactory()->createCreateNewPostController(new JsonModel($uri));
                case '/action/recover-password':
                    return $this->getFactory()->createPasswordRecoveryRequestController(new JsonModel($uri));
                case '/action/summoner/favourite':
                    return $this->getFactory()->createSummonerFavouriteRequestController(new JsonModel($uri));
                case '/action/summoner/unfavourite':
                    return $this->getFactory()->createSummonerUnfavouriteRequestController(new JsonModel($uri));
                case '/action/register/steam':
                    return $this->getFactory()->createSteamRegistrationRequestController(new JsonModel($uri));
            }
        }
    }
}
