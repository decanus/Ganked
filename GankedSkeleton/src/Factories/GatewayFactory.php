<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Service\GetServiceHandler;
    use Ganked\Skeleton\Service\PostServiceHandler;

    class GatewayFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Skeleton\Gateways\SlackGateway
         */
        public function createSlackGateway()
        {
            return new \Ganked\Skeleton\Gateways\SlackGateway(
                $this->createPostServiceHandler(),
                '/slack',
                'token'
            );
        }

        /**
         * @return \Ganked\Skeleton\Gateways\LoLGateway
         */
        public function createLoLGateway()
        {
            return new \Ganked\Skeleton\Gateways\LoLGateway(
                $this->createGetServiceHandler(),
                '/lol',
                'token'
            );
        }

        /**
         * @return \Ganked\Skeleton\Gateways\TwitchGateway
         */
        public function createTwitchGateway()
        {
            return new \Ganked\Skeleton\Gateways\TwitchGateway(
                $this->createGetServiceHandler(),
                '/twitch',
                'token'
            );
        }

        /**
         * @return \Ganked\Skeleton\Gateways\CounterStrikeGateway
         */
        public function createCounterStrikeGateway()
        {
            return new \Ganked\Skeleton\Gateways\CounterStrikeGateway(
                $this->createGetServiceHandler(),
                '/csgo',
                'token'
            );
        }

        /**
         * @return \Ganked\Skeleton\Gateways\DotaGateway
         */
        public function createDotaGateway()
        {
            return new \Ganked\Skeleton\Gateways\DotaGateway(
                $this->createGetServiceHandler(),
                '/dota',
                'token'
            );
        }

        /**
         * @return \Ganked\Skeleton\Gateways\AccountGateway
         */
        public function createAccountGateway()
        {
            return new \Ganked\Skeleton\Gateways\AccountGateway(
                $this->createPostServiceHandler(),
                '/account',
                'token'
            );
        }

        /**
         * @return \Ganked\Skeleton\Gateways\SteamGateway
         */
        public function createSteamGateway()
        {
            return new \Ganked\Skeleton\Gateways\SteamGateway(
                $this->createGetServiceHandler(),
                '/steam',
                'token'
            );
        }

        /**
         * @return \Ganked\Library\Gateways\GankedApiGateway
         * @throws \Exception
         */
        public function createGankedApiGateway()
        {
            return new \Ganked\Library\Gateways\GankedApiGateway(
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('gankedApiUri')),
                $this->getMasterFactory()->getConfiguration()->get('gankedApiKey')
            );
        }

        /**
         * @return \Ganked\Library\Gateways\FavouritesGateway
         * @throws \Exception
         */
        public function createFavouritesGateway()
        {
            return new \Ganked\Library\Gateways\FavouritesGateway(
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('gankedApiUri')),
                $this->getMasterFactory()->getConfiguration()->get('gankedApiKey')
            );
        }

        /**
         * @return GetServiceHandler
         * @throws \Exception
         */
        public function createGetServiceHandler()
        {
            return new \Ganked\Skeleton\Service\GetServiceHandler(
                $this->getMasterFactory()->getConfiguration()->get('serviceUri'),
                $this->getMasterFactory()->createCurl()
            );
        }

        /**
         * @return PostServiceHandler
         * @throws \Exception
         */
        public function createPostServiceHandler()
        {
            return new \Ganked\Skeleton\Service\PostServiceHandler(
                $this->getMasterFactory()->getConfiguration()->get('serviceUri'),
                $this->getMasterFactory()->createCurl()
            );
        }
    }
}
