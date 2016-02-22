<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\Models\RedirectModel;
    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Routers\AbstractRouter;
    use Ganked\Skeleton\Session\SessionData;

    class AccountPageRouter extends AbstractRouter
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
            return $this->routeOnlinePages($request);
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        private function routeOnlinePages(AbstractRequest $request)
        {
            $uri = $request->getUri();
            switch ($uri->getPath()) {
                case '/recover-password':
                    return $this->getFactory()->createPasswordRecoveryController(new ControllerParameterObject($uri));
                case '/account':
                    $controller = $this->getFactory()->createAccountPageController(new ControllerParameterObject($uri));
                    break;
                default:
                    return null;
            }

            if ($this->sessionData->getAccount() instanceof AnonymousAccount) {
                return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToPath($uri, new MovedTemporarily, '/login')));
            }

            return $controller;
        }

    }
}
