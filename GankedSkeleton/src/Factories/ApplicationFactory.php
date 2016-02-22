<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    use Ganked\Library\Curl\CurlHandler;
    use Ganked\Library\Curl\CurlMultiHandler;

    class ApplicationFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Library\Curl\Curl
         */
        public function createCurlHandle()
        {
            return new \Ganked\Library\Curl\Curl(new CurlHandler, new CurlMultiHandler);
        }

        /**
         * @return \Ganked\Library\DataPool\DataPoolWriter
         */
        public function createDataPoolWriter()
        {
            return new \Ganked\Library\DataPool\DataPoolWriter(
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\Library\DataPool\DataPoolReader
         */
        public function createDataPoolReader()
        {
            return new \Ganked\Library\DataPool\DataPoolReader(
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter
         */
        public function createLeagueOfLegendsDataPoolReader()
        {
            return new \Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader(
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\Library\Generators\UriGenerator
         */
        public function createUriGenerator()
        {
            return new \Ganked\Library\Generators\UriGenerator;
        }

        /**
         * @return \Ganked\Library\Generators\ImageUriGenerator
         */
        public function createImageUriGenerator()
        {
            return new \Ganked\Library\Generators\ImageUriGenerator;
        }

    }
}
