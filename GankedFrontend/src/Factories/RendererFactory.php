<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Uri;

    class RendererFactory extends \Ganked\Skeleton\Factories\RendererFactory
    {
        /**
         * @return \Ganked\Frontend\Renderers\AccountPageRenderer
         */
        public function createAccountPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\AccountPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createSteamOpenIdLinkRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\StaticPageRenderer
         */
        public function createStaticPageRenderer()
        {
            $template = $this->getTemplate();

            return new \Ganked\Frontend\Renderers\StaticPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $template,
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createRendererLocator()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer
         */
        public function createLeagueOfLegendsSearchPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createSummonerSnippetRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerSnippetRenderer
         */
        public function createSummonerSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerSnippetRenderer(
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createImageUriGenerator()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\RecentSummonersRenderer
         */
        public function createRecentSummonersRenderer()
        {
            return new \Ganked\Frontend\Renderers\RecentSummonersRenderer(
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createSummonerSnippetRenderer(),
                $this->getMasterFactory()->createFetchAccountFromSessionQuery(),
                $this->getMasterFactory()->createFetchUserFavouriteSummonersQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerPageRenderer
         */
        public function createSummonerPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createSummonerSidebarRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer(),
                $this->getMasterFactory()->createUriGenerator()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerChampionsPageRenderer
         */
        public function createSummonerChampionPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerChampionsPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createSummonerSidebarRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createImageUriGenerator()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerMasteriesPageRenderer
         */
        public function createSummonerMasteriesPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerMasteriesPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createSummonerSidebarRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createMasteriesSnippetRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\UserProfilePageRenderer
         */
        public function createUserProfilePageRenderer()
        {
            return new \Ganked\Frontend\Renderers\UserProfilePageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerComparisonPageRenderer
         */
        public function createSummonerComparisonPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerComparisonPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createNumberRowRenderer(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createImageUriGenerator(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\CounterStrikeUserPageRenderer
         */
        public function createCounterStrikeUserPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\CounterStrikeUserPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createImageUriGenerator(),
                $this->getMasterFactory()->createDataPoolReader(),
                $this->getMasterFactory()->createBarGraphRenderer(),
                $this->getMasterFactory()->createDefinitionBlockSnippetRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\MatchPageRenderer
         */
        public function createMatchPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\MatchPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsChampionTooltipRenderer(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createBarGraphRenderer(),
                $this->getMasterFactory()->createBoolRowRenderer(),
                $this->getMasterFactory()->createNumberRowRenderer(),
                $this->getMasterFactory()->getConfiguration()->isDevelopmentMode()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerMultiSearchRenderer
         */
        public function createSummonerMultiSearchRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerMultiSearchRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\HeaderSnippetRenderer
         */
        public function createHeaderSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\HeaderSnippetRenderer(
                $this->getMasterFactory()->createDomBackend()
            );
        }


        /**
         * @return \Ganked\Frontend\Renderers\TrackingSnippetRenderer
         * @throws \Exception
         */
        public function createTrackingSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\TrackingSnippetRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getMasterFactory()->getConfiguration()->get('isDevelopmentMode') === 'false'
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
         */
        public function createAppendCSRFTokenSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer(
                $this->getMasterFactory()->createSession()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
         */
        public function createSignInLinksSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer(
                $this->getMasterFactory()->createSession()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerRunesPagePageRenderer
         */
        public function createSummonerRunesPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerRunesPagePageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createSummonerSidebarRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchBarRenderer(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createLeagueOfLegendsRunesSnippetRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\MetaTagsSnippetsRenderer
         */
        public function createMetaTagsSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\MetaTagsSnippetsRenderer;
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerSidebarRenderer
         */
        public function createSummonerSidebarRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerSidebarRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createImageUriGenerator()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer
         */
        public function createPasswordRecoveryPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createXslRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer
         */
        public function createSummonerCurrentGamePageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsChampionTooltipRenderer(),
                $this->getMasterFactory()->createUriGenerator(),
                $this->getMasterFactory()->createImageUriGenerator(),
                $this->getMasterFactory()->createLeagueOfLegendsBannedChampionsRenderer(),
                $this->getMasterFactory()->createMasteriesSnippetRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsRunesSnippetRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\LeagueOfLegendsSearchBarRenderer
         */
        public function createLeagueOfLegendsSearchBarRenderer()
        {
            return new \Ganked\Frontend\Renderers\LeagueOfLegendsSearchBarRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getMasterFactory()->createFetchDefaultLeagueOfLegendsRegionFromSessionQuery(),
                $this->getMasterFactory()->createHasDefaultLeagueOfLegendsRegionFromSessionQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\GenericPageRenderer
         */
        public function createGenericPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\GenericPageRenderer(
                $this->getMasterFactory()->createSignInLinksSnippetRenderer(),
                $this->getMasterFactory()->createMetaTagsSnippetRenderer(),
                $this->getMasterFactory()->createTrackingSnippetRenderer(),
                $this->getMasterFactory()->createHeaderSnippetRenderer(),
                $this->getMasterFactory()->createAppendCSRFTokenSnippetRenderer(),
                $this->getMasterFactory()->createInfoBarRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\InfoBarRenderer
         */
        public function createInfoBarRenderer()
        {
            return new \Ganked\Frontend\Renderers\InfoBarRenderer(
                $this->getMasterFactory()->createDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\BoolRowRenderer$
         */
        public function createBoolRowRenderer()
        {
            return new \Ganked\Frontend\Renderers\BoolRowRenderer;
        }

        /**
         * @return \Ganked\Frontend\Renderers\NumberRowRenderer
         */
        public function createNumberRowRenderer()
        {
            return new \Ganked\Frontend\Renderers\NumberRowRenderer();
        }

        /**
         * @return \Ganked\Frontend\Renderers\BarGraphRenderer
         */
        public function createBarGraphRenderer()
        {
            return new \Ganked\Frontend\Renderers\BarGraphRenderer;
        }

        /**
         * @return \Ganked\Frontend\Renderers\LeagueOfLegendsChampionTooltipRenderer
         */
        public function createLeagueOfLegendsChampionTooltipRenderer()
        {
            return new \Ganked\Frontend\Renderers\LeagueOfLegendsChampionTooltipRenderer;
        }

        /**
         * @return \Ganked\Frontend\Renderers\LeagueOfLegendsBannedChampionsRenderer
         */
        public function createLeagueOfLegendsBannedChampionsRenderer()
        {
            return new \Ganked\Frontend\Renderers\LeagueOfLegendsBannedChampionsRenderer(
                $this->getMasterFactory()->createLeagueOfLegendsChampionTooltipRenderer(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\MasteriesSnippetRenderer
         */
        public function createMasteriesSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\MasteriesSnippetRenderer(
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SteamOpenIdLinkRenderer
         * @throws \Exception
         */
        public function createSteamOpenIdLinkRenderer()
        {
            return new \Ganked\Frontend\Renderers\SteamOpenIdLinkRenderer(
                new \LightOpenID($this->getMasterFactory()->getConfiguration()->get('domain')),
                new Uri($this->getMasterFactory()->getConfiguration()->get('domain'))
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\LeagueOfLegendsRunesSnippetRenderer
         */
        public function createLeagueOfLegendsRunesSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\LeagueOfLegendsRunesSnippetRenderer(
                $this->getMasterFactory()->createImageUriGenerator()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SteamRegistrationPageRenderer
         */
        public function createSteamRegistrationPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SteamRegistrationPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SteamLoginPageRenderer
         */
        public function createSteamLoginPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SteamLoginPageRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\SteamConnectRenderer
         */
        public function createSteamConnectPageRenderer()
        {
            return new \Ganked\Frontend\Renderers\SteamConnectRenderer(
                $this->getMasterFactory()->createDomBackend(),
                $this->getTemplate(),
                $this->getMasterFactory()->createSnippetTransformation(),
                $this->getMasterFactory()->createTextTransformation(),
                $this->getMasterFactory()->createGenericPageRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Renderers\DefinitionBlockSnippetRenderer
         */
        public function createDefinitionBlockSnippetRenderer()
        {
            return new \Ganked\Frontend\Renderers\DefinitionBlockSnippetRenderer;
        }

        /**
         * @return DomHelper
         */
        private function getTemplate()
        {
            return $this->getMasterFactory()->createDomBackend()->getDomFromXML('templates://template.xhtml');
        }
    }
}
