<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Frontend\Routers\SearchPageRouter
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Frontend\Factories\ReaderFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     * @uses Ganked\Frontend\Factories\MapperFactory
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\CommandFactory
     * @uses Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Frontend\Controllers\AbstractPageController
     * @uses Ganked\Frontend\Controllers\SearchPageController
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Skeleton\Session\Session
     * @uses Ganked\Frontend\Models\SearchPageModel
     * @uses Ganked\Frontend\Queries\FetchSummonersByNameQuery
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Queries\FetchMatchlistsForSummonersInRegionByUsernameQuery
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Controllers\SummonerMultiSearchController
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper
     * @uses \Ganked\Frontend\Queries\SummonerMultiSearchQuery
     * @uses \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsSearchBarRenderer
     * @uses \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand
     * @uses \Ganked\Frontend\Renderers\SummonerMultiSearchRenderer
     * @uses \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\ParameterObjects\ControllerParameterObject
     * @uses \Ganked\Frontend\Renderers\SummonerSnippetRenderer
     * @uses \Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery
     * @uses \Ganked\Frontend\Queries\AbstractLeagueOfLegendsQuery
     */
    class SearchPageRouterTest extends GenericRouterTestHelper
    {
        private $sessionData;

        protected function setUp()
        {
            parent::setUp();
            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->router = new SearchPageRouter($this->masterFactory, $this->sessionData);
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @param $path
         * @param $instance
         * @dataProvider provideInstanceNames
         */
        public function testCreateRouteWorks($path, $instance)
        {
            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\AnonymousAccount::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will($this->returnValue($account));

            parent::testCreateRouteWorks($path, $instance);
        }

        public function testCreateRouteRedirectsIfOffline()
        {
            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\RegisteredAccount::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will($this->returnValue($account));

            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $request
                ->expects($this->once())
                ->method('getUri')
                ->will($this->returnValue($uri));

            $uri
                ->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue('/games/cs-go/search'));

            $this->assertInstanceOf(\Ganked\Skeleton\Controllers\GetController::class, $this->router->route($request));
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/games/cs-go/search', \Ganked\Skeleton\Controllers\GetController::class],
                ['/games/lol/search', \Ganked\Frontend\Controllers\SearchPageController::class],
                ['/games/lol/search/multi', \Ganked\Frontend\Controllers\SummonerMultiSearchController::class],
            ];
        }
    }
}
