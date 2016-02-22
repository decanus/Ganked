<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Routers
{

    use Ganked\Services\Models\ServiceModel;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class ServiceRouter extends AbstractRouter
    {

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         * @throws \Exception
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();

            $model = new ServiceModel($uri);

            if ($request->hasParameter('arguments')) {
                $model->setArguments(json_decode($request->getParameter('arguments'), true));
            }

            switch ($uri->getPath()) {
                case '/slack':
                    $controller = $this->getFactory()->createSlackController($model);
                    break;
                case '/twitch':
                    $controller = $this->getFactory()->createTwitchServiceClientController($model);
                    break;
                case '/lol':
                    $controller = $this->getFactory()->createLoLServiceClientController($model);
                    break;
                case '/csgo':
                    $controller = $this->getFactory()->createCounterStrikeServiceClientController($model);
                    break;
                case '/dota':
                    $controller = $this->getFactory()->createDotaServiceClientController($model);
                    break;
                case '/account':
                    $controller = $this->getFactory()->createAccountServiceClientController($model);
                    break;
                case '/steam':
                    $controller = $this->getFactory()->createSteamServiceClientController($model);
                    break;
            }


            if (!isset($controller)) {
                return;
            }

            if (!$request->hasParameter('token')) {
                throw new \Exception('Token not set for "' . $uri->getPath() . '"');
            }

            if (!$request->hasParameter('method')) {
                throw new \Exception('Request requires method');
            }

            $model->setMethod($request->getParameter('method'));

            return $controller;
        }
    }
}

