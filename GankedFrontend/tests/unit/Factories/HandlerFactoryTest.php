<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{
    /**
     * @covers Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Frontend\Factories\CommandFactory
     * @uses \Ganked\Frontend\Queries\FetchSummonersByNameQuery
     * @uses \Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses \Ganked\Frontend\Renderers\SummonerSnippetRenderer
     * @uses \Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery
     * @uses \Ganked\Frontend\Queries\AbstractLeagueOfLegendsQuery
     * @uses \Ganked\Frontend\Handlers\Get\ResponseHandler
     * @uses \Ganked\Frontend\Handlers\Get\PostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     */
    class HandlerFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLeagueOfLegendsSearchHandler', \Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler::class],
                ['createCommandHandler', \Ganked\Frontend\Handlers\CommandHandler::class],
                ['createPreHandler', \Ganked\Frontend\Handlers\PreHandler::class],
                ['createQueryHandler', \Ganked\Frontend\Handlers\QueryHandler::class],
                ['createTransformationHandler', \Ganked\Frontend\Handlers\TransformationHandler::class],
                ['createGetResponseHandler', \Ganked\Frontend\Handlers\Get\ResponseHandler::class],
                ['createGetPostHandler', \Ganked\Frontend\Handlers\Get\PostHandler::class],
            ];
        }
    }
}
