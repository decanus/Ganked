<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class ReaderFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Frontend\Readers\UrlRedirectReader
         */
        public function createUrlRedirectReader()
        {
            return new \Ganked\Frontend\Readers\UrlRedirectReader(
                $this->getMasterFactory()->createFileBackend()
            );
        }

        /**
         * @return \Ganked\Frontend\Readers\LeagueOfLegendsReader
         */
        public function createLeagueOfLegendsReader()
        {
            return new \Ganked\Frontend\Readers\LeagueOfLegendsReader(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Readers\UserReader
         */
        public function createUserReader()
        {
            return new \Ganked\Frontend\Readers\UserReader(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Readers\CounterStrikeReader
         */
        public function createCounterStrikeReader()
        {
            return new \Ganked\Frontend\Readers\CounterStrikeReader(
                $this->getMasterFactory()->createCounterStrikeGateway()
            );
        }
    }
}
