<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\Readers\UserReader;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class UserPageRouter extends AbstractRouter
    {
        /**
         * @var UserReader
         */
        private $userReader;

        /**
         * @param MasterFactory $factory
         * @param UserReader    $userReader
         */
        public function __construct(MasterFactory $factory, UserReader $userReader)
        {
            parent::__construct($factory);
            $this->userReader = $userReader;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();

            $paths = $uri->getExplodedPath();

            if ($paths[0] !== 'profile' || !isset($paths[1])) {
                return;
            }

            try {
                $username = new Username($paths[1]);
            } catch (\InvalidArgumentException $e) {
                return;
            }

            if (!$this->userReader->hasUserWithUsername($username)) {
                return;
            }

            if (isset($paths[2])) {
                return;
            }
            
            return $this->getFactory()->createUserProfilePageController(new ControllerParameterObject($uri));
        }
    }
}
