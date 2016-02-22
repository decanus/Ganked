<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{
    /**
     * @covers Ganked\Backend\Factories\BuilderFactory
     * @uses Ganked\Backend\Factories\BackendFactory
     * @uses Ganked\Backend\Factories\LocatorFactory
     * @uses Ganked\Backend\Writers\StaticPageWriter
     * @uses \Ganked\Backend\Builders\StaticPageBuilder
     * @uses \Ganked\Backend\Builders\ChampionsPageBuilder
     * @uses \Ganked\Backend\Builders\ChampionPageBuilder
     * @uses \Ganked\Backend\Builders\CounterStrikeAchievementsTemplateBuilder
     * @uses \Ganked\Backend\Builders\LeagueOfLegendsMasteriesTemplateBuilder
     * @uses \Ganked\Backend\Factories\RendererFactory
     * @uses \Ganked\Backend\Locators\RendererLocator
     */
    class BuilderFactoryTest extends GenericFactoryTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
            $this->getMasterFactory()->addFactory(new \Ganked\Skeleton\Factories\TransformationFactory);
        }


        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createStaticPageBuilder', \Ganked\Backend\Builders\StaticPageBuilder::class],
                ['createChampionsPageBuilder', \Ganked\Backend\Builders\ChampionsPageBuilder::class],
                ['createChampionPageBuilder', \Ganked\Backend\Builders\ChampionPageBuilder::class],
                ['createLeagueOfLegendsMasteriesTemplateBuilder', \Ganked\Backend\Builders\LeagueOfLegendsMasteriesTemplateBuilder::class],
                ['createCounterStrikeAchievementsTemplateBuilder', \Ganked\Backend\Builders\CounterStrikeAchievementsTemplateBuilder::class],
            ];
        }
    }
}
