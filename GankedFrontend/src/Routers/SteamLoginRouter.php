<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Routers\AbstractRouter;
    use Ganked\Skeleton\Session\SessionData;

    class SteamLoginRouter extends AbstractRouter
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @param MasterFactory $factory
         * @param SessionData   $sessionData
         */
        public function __construct(MasterFactory $factory, SessionData $sessionData)
        {
            parent::__construct($factory);
            $this->sessionData = $sessionData;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();

            switch ($uri->getPath()) {
                case '/register/steam':
                    return $this->getFactory()->createSteamRegistrationController(new ControllerParameterObject($uri));
                case '/connect/steam':
                    return $this->getFactory()->createSteamConnectController(new ControllerParameterObject($uri));
            }

            if ($this->sessionData->isSteamLoginLocked()) {
                return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToPath($uri, new MovedTemporarily, '/register/steam')));
            }

            if ($uri->getPath() !== '/login/steam') {
                return;
            }

            if ($this->sessionData->getAccount() instanceof RegisteredAccount) {
                return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToPath($uri, new MovedTemporarily, '/')));
            }

            return $this->getFactory()->createSteamLoginController(new ControllerParameterObject($uri));
        }
    }
}
