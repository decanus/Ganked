<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Routers\AbstractRouter;
    use Ganked\Skeleton\Session\SessionData;

    class StaticPageRouter extends AbstractRouter
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param MasterFactory  $factory
         * @param DataPoolReader $dataPoolReader
         * @param SessionData    $sessionData
         */
        public function __construct(MasterFactory $factory, DataPoolReader $dataPoolReader, SessionData $sessionData)
        {
            parent::__construct($factory);
            $this->sessionData = $sessionData;
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();
            $path = $uri->getPath();

            if (!$this->dataPoolReader->hasStaticPage($path)) {
                return;
            }

            switch ($path) {
                case '/login':
                case '/register':
                case '/verification/error':
                case '/verification/success':
                    if ($this->sessionData->getAccount() instanceof RegisteredAccount) {
                            return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToPath($uri, new MovedTemporarily, '/'))
                        );
                    }
            }

            return $this->getFactory()->createStaticPageController(new ControllerParameterObject($uri));
        }
    }
}

