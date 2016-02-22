<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Frontend\Factories\LocatorFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Frontend\Factories\ReaderFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Frontend\Renderers\StaticPageRenderer
     * @uses Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer
     * @uses Ganked\Library\Helpers\DomHelper
     * @uses \Ganked\Frontend\Renderers\SummonerPageRenderer
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\UserProfilePageRenderer
     * @uses \Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer
     * @uses \Ganked\Frontend\Locators\RendererLocator
     * @uses \Ganked\Frontend\Renderers\AbstractSummonerPageRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerSidebarRenderer
     * @uses \Ganked\Frontend\Renderers\RecentSummonersRenderer
     * @uses \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsSearchBarRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerMultiSearchRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer
     * @uses \Ganked\Frontend\Renderers\BarGraphRenderer
     * @uses \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\MasteriesSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerMasteriesPageRenderer
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsBannedChampionsRenderer
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsRunesSnippetRenderer
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsCurrentGameMapper
     * @uses \Ganked\Frontend\Renderers\SummonerRunesPagePageRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerChampionsPageRenderer
     * @uses \Ganked\Frontend\Renderers\MatchPageRenderer
     * @uses \Ganked\Frontend\Renderers\SteamOpenIdLinkRenderer
     * @uses \Ganked\Frontend\Renderers\CounterStrikeUserPageRenderer
     * @uses \Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery
     * @uses \Ganked\Frontend\Renderers\AccountPageRenderer
     */
    class RendererFactoryTest extends GenericFactoryTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
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
                ['createAccountPageRenderer', \Ganked\Frontend\Renderers\AccountPageRenderer::class],
                ['createLeagueOfLegendsSearchPageRenderer', \Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer::class],
                ['createStaticPageRenderer', \Ganked\Frontend\Renderers\StaticPageRenderer::class],
                ['createSummonerPageRenderer', \Ganked\Frontend\Renderers\SummonerPageRenderer::class],
                ['createHeaderSnippetRenderer', \Ganked\Frontend\Renderers\HeaderSnippetRenderer::class],
                ['createTrackingSnippetRenderer', \Ganked\Frontend\Renderers\TrackingSnippetRenderer::class],
                ['createAppendCSRFTokenSnippetRenderer', \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer::class],
                ['createSignInLinksSnippetRenderer', \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer::class],
                ['createCounterStrikeUserPageRenderer', \Ganked\Frontend\Renderers\CounterStrikeUserPageRenderer::class],
                ['createUserProfilePageRenderer', \Ganked\Frontend\Renderers\UserProfilePageRenderer::class],
                ['createPasswordRecoveryPageRenderer', \Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer::class],
                ['createRecentSummonersRenderer', \Ganked\Frontend\Renderers\RecentSummonersRenderer::class],
                ['createSummonerMasteriesPageRenderer', \Ganked\Frontend\Renderers\SummonerMasteriesPageRenderer::class],
                ['createSummonerMultiSearchRenderer', \Ganked\Frontend\Renderers\SummonerMultiSearchRenderer::class],
                ['createSummonerRunesPageRenderer', \Ganked\Frontend\Renderers\SummonerRunesPagePageRenderer::class],
                ['createSummonerCurrentGamePageRenderer', \Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer::class],
                ['createBarGraphRenderer', \Ganked\Frontend\Renderers\BarGraphRenderer::class],
                ['createGenericPageRenderer', \Ganked\Frontend\Renderers\GenericPageRenderer::class],
                ['createInfoBarRenderer', \Ganked\Frontend\Renderers\InfoBarRenderer::class],
                ['createMasteriesSnippetRenderer', \Ganked\Frontend\Renderers\MasteriesSnippetRenderer::class],
                ['createSummonerChampionPageRenderer', \Ganked\Frontend\Renderers\SummonerChampionsPageRenderer::class],
                ['createMatchPageRenderer', \Ganked\Frontend\Renderers\MatchPageRenderer::class],
                ['createBoolRowRenderer', \Ganked\Frontend\Renderers\BoolRowRenderer::class],
                ['createSteamOpenIdLinkRenderer', \Ganked\Frontend\Renderers\SteamOpenIdLinkRenderer::class],
                ['createSteamRegistrationPageRenderer', \Ganked\Frontend\Renderers\SteamRegistrationPageRenderer::class],
                ['createSteamLoginPageRenderer', \Ganked\Frontend\Renderers\SteamLoginPageRenderer::class],
            ];
        }
    }
}
