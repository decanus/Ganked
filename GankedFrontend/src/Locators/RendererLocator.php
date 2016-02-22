<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Locators
{

    use Ganked\Skeleton\Factories\MasterFactory;

    class RendererLocator
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @param MasterFactory $factory
         */
        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        /**
         * @param string $renderer
         *
         * @return mixed
         */
        public function locate($renderer)
        {
            switch ($renderer) {
                case 'recentSummoners':
                    return $this->factory->createRecentSummonersRenderer();
                case 'lolSearchBar':
                    return $this->factory->createLeagueOfLegendsSearchBarRenderer();
                case 'steamLogin':
                    return $this->factory->createSteamOpenIdLinkRenderer();
            }
        }
    }
}
