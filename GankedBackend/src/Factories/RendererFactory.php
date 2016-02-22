<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class RendererFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Backend\Renderers\BreadcrumbsRenderer
         */
        public function createBreadcrumbsRenderer()
        {
            return new \Ganked\Backend\Renderers\BreadcrumbsRenderer;
        }

        /**
         * @return \Ganked\Backend\Renderers\LeagueOfLegendsFreeChampionsRenderer
         */
        public function createLeagueOfLegendsFreeChampionsRenderer()
        {
            return new \Ganked\Backend\Renderers\LeagueOfLegendsFreeChampionsRenderer(
                $this->getMasterFactory()->createDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Backend\Renderers\RssFeedsRenderer
         */
        public function createRssFeedsRenderer()
        {
            return new \Ganked\Backend\Renderers\RssFeedsRenderer(
                $this->getMasterFactory()->createDataPoolReader(),
                new \DateTime
            );
        }
    }
}
