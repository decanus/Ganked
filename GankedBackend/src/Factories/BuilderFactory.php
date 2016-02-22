<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class BuilderFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Backend\Builders\StaticPageBuilder
         */
        public function createStaticPageBuilder()
        {
            return new \Ganked\Backend\Builders\StaticPageBuilder(
                $this->getMasterFactory()->createFileBackend(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createRendererLocator(),
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode()
            );
        }

        /**
         * @return \Ganked\Backend\Builders\ChampionsPageBuilder
         */
        public function createChampionsPageBuilder()
        {
            return new \Ganked\Backend\Builders\ChampionsPageBuilder(
                $this->getMasterFactory()->createFileBackend(),
                $this->getMasterFactory()->createDomBackend(),
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createSnippetTransformation()
            );
        }

        /**
         * @return \Ganked\Backend\Builders\ChampionPageBuilder
         */
        public function createChampionPageBuilder()
        {
            return new \Ganked\Backend\Builders\ChampionPageBuilder(
                $this->getMasterFactory()->createDomBackend(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createBreadcrumbsRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Backend\Builders\LeagueOfLegendsMasteriesTemplateBuilder
         */
        public function createLeagueOfLegendsMasteriesTemplateBuilder()
        {
            return new \Ganked\Backend\Builders\LeagueOfLegendsMasteriesTemplateBuilder(
                $this->getMasterFactory()->createDomBackend()
            );
        }

        /**
         * @return \Ganked\Backend\Builders\CounterStrikeAchievementsTemplateBuilder
         */
        public function createCounterStrikeAchievementsTemplateBuilder()
        {
            return new \Ganked\Backend\Builders\CounterStrikeAchievementsTemplateBuilder(
                $this->getMasterFactory()->createImageUriGenerator()
            );
        }
    }
}
