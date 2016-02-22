<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Services\Factories
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Factories\AbstractFactory;

    class ServiceClientFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Services\ServiceClients\API\LoLServiceClient
         */
        public function createLoLServiceClient()
        {
            $configuration = $this->getMasterFactory()->getConfiguration();
            return new \Ganked\Services\ServiceClients\API\LoLServiceClient(
                $this->getMasterFactory()->createCacheBackend(),
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($configuration->get('riotApiBaseUri')),
                $configuration->get('riotApiKey'),
                $this->getMasterFactory()->createDataPoolWriter(),
                $this->getMasterFactory()->createLeagueOfLegendsMongoBackend()
            );
        }

        /**
         * @return \Ganked\Services\ServiceClients\API\CounterStrikeServiceClient
         */
        public function createCounterStrikeServiceClient()
        {
            return new \Ganked\Services\ServiceClients\API\CounterStrikeServiceClient(
                $this->getMasterFactory()->createCacheBackend(),
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('steamApiBaseUri')),
                $this->getMasterFactory()->getConfiguration()->get('steamApiKey'),
                $this->getMasterFactory()->getConfiguration()->get('counterStrikeAppId')
            );
        }


        /**
         * @return \Ganked\Services\ServiceClients\API\CounterStrikeServiceClient
         */
        public function createSteamServiceClient()
        {
            return new \Ganked\Services\ServiceClients\API\SteamServiceClient(
                $this->getMasterFactory()->createCacheBackend(),
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('steamApiBaseUri')),
                $this->getMasterFactory()->getConfiguration()->get('steamApiKey')
            );
        }

        /**
         * @return \Ganked\Services\ServiceClients\API\DotaServiceClient
         * @throws \Exception
         */
        public function createDotaServiceClient()
        {
            return new \Ganked\Services\ServiceClients\API\DotaServiceClient(
                $this->getMasterFactory()->createCacheBackend(),
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('steamApiBaseUri')),
                $this->getMasterFactory()->getConfiguration()->get('steamApiKey'),
                $this->getMasterFactory()->getConfiguration()->get('counterStrikeAppId')
            );
        }

        /**
         * @return \Ganked\Services\ServiceClients\API\TwitchServiceClient
         */
        public function createTwitchServiceClient()
        {
            return new \Ganked\Services\ServiceClients\API\TwitchServiceClient(
                $this->getMasterFactory()->createCacheBackend(),
                $this->getMasterFactory()->createCurlHandle(),
                new Uri($this->getMasterFactory()->getConfiguration()->get('twitchBaseUri')),
                $this->getMasterFactory()->getConfiguration()->get('clientSecret')
            );
        }

        /**
         * @return \Ganked\Services\ServiceClients\Account\AccountServiceClient
         * @codeCoverageIgnore
         */
        public function createAccountServiceClient()
        {
            return new \Ganked\Services\ServiceClients\Account\AccountServiceClient(
                $this->getMasterFactory()->createMongoBackend()
            );
        }
    }
}
