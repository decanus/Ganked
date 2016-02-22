<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class SearchPageRouter extends AbstractRouter
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

            switch ($uri->getPath()) {
                case '/games/cs-go/search':
                    return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToPath($uri, new MovedTemporarily, '/games/cs-go/users/' . urlencode(strtolower($request->getParameter('name'))))));
                    break;
                case '/games/lol/search':
                    return $this->getFactory()->createLeagueOfLegendsSearchPageController(new ControllerParameterObject($uri));
                case '/games/lol/search/multi':
                    return $this->getFactory()->createLeagueOfLegendsSearchMultiPageController(new ControllerParameterObject($uri));
            }
        }
    }
}
