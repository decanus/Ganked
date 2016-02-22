<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\Readers\CounterStrikeReader;
    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class CounterStrikePageRouter extends AbstractRouter
    {
        /**
         * @var CounterStrikeReader
         */
        private $counterStrikeReader;

        /**
         * @param MasterFactory       $factory
         * @param CounterStrikeReader $counterStrikeReader
         */
        public function __construct(MasterFactory $factory, CounterStrikeReader $counterStrikeReader)
        {
            parent::__construct($factory);
            $this->counterStrikeReader = $counterStrikeReader;
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

            if (count($paths) !== 4) {
                return;
            }

            return $this->routeCounterStrikeUser($uri);
        }

        /**
         * @param Uri $uri
         */
        private function routeCounterStrikeUser(Uri $uri)
        {
            $paths = $uri->getExplodedPath();

            if ($paths[0] !== 'games' || $paths[1] !== 'cs-go' || $paths[2] !== 'users') {
                return;
            }

            if (!$this->isSteamId($paths[3]) && !$this->isSteamCustomId($paths[3])) {
                return;
            }

            return $this->getFactory()->createCounterStrikeUserPageController(new ControllerParameterObject($uri));
        }

        /**
         * @param string $steamId
         *
         * @return bool
         */
        private function isSteamId($steamId)
        {
            try {
                return $this->counterStrikeReader->hasSteamUserWithId(new SteamId($steamId));
            } catch (\Exception $e) {
                return false;
            }
        }

        /**
         * @param string $steamId
         *
         * @return bool
         */
        private function isSteamCustomId($steamId)
        {
            try {
                return $this->counterStrikeReader->hasSteamUserWithCustomId(new SteamCustomId($steamId));
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
