<?php

namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Frontend\Routers\LeagueOfLegendsPageRouter
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Frontend\Factories\ReaderFactory
     * @uses Ganked\Frontend\Factories\MapperFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses \Ganked\Frontend\Controllers\AbstractPageController
     * @uses Ganked\Skeleton\Session\Session
     * @uses Ganked\Frontend\Renderers\StaticPageRenderer
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Frontend\Models\SummonerPageModel
     * @uses \Ganked\Frontend\Controllers\SummonerPageController
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses \Ganked\Frontend\Controllers\SummonerPageController
     * @uses \Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery
     * @uses \Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery
     * @uses \Ganked\Frontend\Renderers\SummonerPageRenderer
     * @uses \Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\AbstractSummonerPageRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerSidebarRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer
     * @uses \Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper
     * @uses \Ganked\Frontend\Queries\FetchRunesForSummonerQuery
     * @uses \Ganked\Frontend\Controllers\SummonerRunePageController
     * @uses \Ganked\Frontend\Controllers\SummonerMasteriesPageController
     * @uses \Ganked\Frontend\Controllers\AbstractSummonerPageController
     * @uses \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsSearchBarRenderer
     * @uses \Ganked\Frontend\Controllers\SummonerCurrentGameController
     * @uses \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\ParameterObjects\ControllerParameterObject
     * @uses \Ganked\Frontend\Queries\AbstractLeagueOfLegendsQuery
     * @uses \Ganked\Frontend\Renderers\MasteriesSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerMasteriesPageRenderer
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsBannedChampionsRenderer
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsRunesSnippetRenderer
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsCurrentGameMapper
     * @uses \Ganked\Frontend\Renderers\SummonerRunesPagePageRenderer
     * @uses \Ganked\Frontend\Controllers\SummonerChampionsPageController
     * @uses \Ganked\Frontend\Renderers\MatchPageRenderer
     * @uses \Ganked\Frontend\Controllers\MatchPageController
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsMatchOverviewMapper
     * @uses \Ganked\Frontend\Renderers\SummonerChampionsPageRenderer
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     */
    class LeagueOfLegendsPageRouterTest extends GenericRouterTestHelper
    {
        private $reader;

        protected function setUp()
        {
            parent::setUp();
            $this->reader = $this->getMockBuilder(\Ganked\Frontend\Readers\LeagueOfLegendsReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->reader->expects($this->any())->method('hasSummonerForRegionWithName')->will($this->returnValue(true));
            $this->reader->expects($this->any())->method('hasMatchForRegionById')->will($this->returnValue(true));

            $this->router = new LeagueOfLegendsPageRouter(
                $this->masterFactory,
                $this->reader
            );
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/games/lol/summoners/euw/test', \Ganked\Frontend\Controllers\SummonerPageController::class],
                ['/games/lol/summoners/euw/test/runes', \Ganked\Frontend\Controllers\SummonerRunePageController::class],
                ['/games/lol/summoners/euw/test/masteries', \Ganked\Frontend\Controllers\SummonerMasteriesPageController::class],
                ['/games/lol/summoners/euw/test/current', \Ganked\Frontend\Controllers\SummonerCurrentGameController::class],
                ['/games/lol/summoners/euw/test/champions', \Ganked\Frontend\Controllers\SummonerChampionsPageController::class],
                ['/games/lol/matches/euw/12345', \Ganked\Frontend\Controllers\MatchPageController::class],
                ['/games/lol/summoners/compare', \Ganked\Frontend\Controllers\SummonerComparisonPageController::class],
            ];
        }
    }
}
