<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Locators
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
         * @param string $type
         *
         * @return mixed
         * @throws \InvalidArgumentException
         */
        public function locate($type)
        {
            switch ($type) {
                case 'leagueOfLegendsFreeChampions':
                    return $this->factory->createLeagueOfLegendsFreeChampionsRenderer();
                case 'rssList':
                    return $this->factory->createRssFeedsRenderer();
                default:
                    throw new \InvalidArgumentException('Renderer of type "' . $type . '" not found');
            }
        }
    }
}
