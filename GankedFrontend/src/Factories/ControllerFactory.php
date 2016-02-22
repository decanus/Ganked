<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Factories
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Skeleton\Http\Response\HtmlResponse;

    class ControllerFactory extends \Ganked\Skeleton\Factories\ControllerFactory
    {

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Skeleton\Controllers\GetController
         */
        public function createAccountPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Skeleton\Controllers\GetController(
                $this->createModel(\Ganked\Frontend\Models\AccountPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createAccountPageQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createAccountPageTransformationHandler(),
                $this->getMasterFactory()->createGetResponseHandler(),
                $this->getMasterFactory()->createGetPostHandler(),
                new HtmlResponse
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Skeleton\Controllers\GetController
         */
        public function createSteamConnectController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Skeleton\Controllers\GetController(
                $this->createModel(\Ganked\Frontend\Models\SteamConnectModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createSteamConnectPreHandler(),
                $this->getMasterFactory()->createSteamConnectQueryHandler(),
                $this->getMasterFactory()->createSteamConnectCommandHandler(),
                $this->getMasterFactory()->createSteamConnectTransformationHandler(),
                $this->getMasterFactory()->createGetResponseHandler(),
                $this->getMasterFactory()->createGetPostHandler(),
                new HtmlResponse
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\StaticPageController
         */
        public function createStaticPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\StaticPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createStaticPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\StaticPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createDataPoolReader()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SearchPageController
         */
        public function createLeagueOfLegendsSearchPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SearchPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\LeagueOfLegendsSearchPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSearchHandler()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SummonerPageController
         */
        public function createSummonerPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SummonerPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerMapper(),
                $this->getMasterFactory()->createHasUserFavouritedSummonerQuery(),
                $this->getMasterFactory()->createFetchRecentGamesForSummonerQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsRecentGamesMapper()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SummonerChampionsPageController
         */
        public function createSummonerChampionsPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerChampionsPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerChampionPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SummonerChampionsPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerMapper(),
                $this->getMasterFactory()->createHasUserFavouritedSummonerQuery(),
                $this->getMasterFactory()->createFetchRankedStatsForSummonerQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\PageController
         */
        public function createCounterStrikeUserPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\CounterStrikeUserPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createCounterStrikeUserPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SteamUserPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createCounterStrikeUserMapper(),
                $this->getMasterFactory()->createCounterStrikeGateway(),
                $this->getMasterFactory()->createFetchPlayerBansQuery(),
                $this->getMasterFactory()->createResolveVanityUrlQuery()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\PasswordRecoveryPageController
         */
        public function createPasswordRecoveryController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\PasswordRecoveryPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createPasswordRecoveryPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\PasswordRecoveryPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createFetchUserHashQuery()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\UserProfilePageController
         */
        public function createUserProfilePageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\UserProfilePageController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createUserProfilePageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\UserProfileModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\UserProfilePageController
         */
        public function createSummonerComparisonPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerComparisonPageController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerComparisonPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SummonerComparisonPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createFetchSummonerComparisonStatsQuery()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\MatchPageController
         */
        public function createMatchPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\MatchPageController(
                new HtmlResponse,
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createMatchPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\MatchPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createFetchMatchForRegionQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsMatchOverviewMapper()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SummonerRunePageController
         */
        public function createSummonerRunePageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerRunePageController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerRunesPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SummonerRunesPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerMapper(),
                $this->getMasterFactory()->createHasUserFavouritedSummonerQuery(),
                $this->getMasterFactory()->createFetchRunesForSummonerQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerRunesMapper()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SummonerMasteriesPageController
         */
        public function createSummonerMasteriesPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerMasteriesPageController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerMasteriesPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SummonerMasteriesPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerMapper(),
                $this->getMasterFactory()->createHasUserFavouritedSummonerQuery(),
                $this->getMasterFactory()->createFetchMasteriesForSummonerQuery()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SummonerMultiSearchController
         */
        public function createLeagueOfLegendsSearchMultiPageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerMultiSearchController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerMultiSearchRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SearchPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createSummonerMultiSearchQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsMultiSearchMapper(),
                $this->getMasterFactory()->createSaveDefaultLeagueOfLegendsRegionInSessionCommand()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SummonerCurrentGameController
         */
        public function createSummonerCurrentGamePageController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SummonerCurrentGameController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSummonerCurrentGamePageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SummonerCurrentGamePageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createFetchSummonerCurrentGameQuery(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerMapper(),
                $this->getMasterFactory()->createLeagueOfLegendsCurrentGameMapper()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SteamLoginController
         */
        public function createSteamLoginController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SteamLoginController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSteamLoginPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\PageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                new \LightOpenID($this->getMasterFactory()->getConfiguration()->get('domain')),
                $this->getMasterFactory()->createLockSessionForSteamLoginCommand(),
                $this->getMasterFactory()->createSaveSteamIdInSessionCommand(),
                $this->getMasterFactory()->createHasUserBySteamIdQuery()
            );
        }

        /**
         * @param ControllerParameterObject $parameterObject
         *
         * @return \Ganked\Frontend\Controllers\SteamRegistrationPageController
         */
        public function createSteamRegistrationController(ControllerParameterObject $parameterObject)
        {
            return new \Ganked\Frontend\Controllers\SteamRegistrationPageController(
                new HtmlResponse(),
                $this->getMasterFactory()->createFetchSessionCookieQuery(),
                $this->getMasterFactory()->createSteamRegistrationPageRenderer(),
                $this->createModel(\Ganked\Frontend\Models\SteamRegistrationPageModel::class, $parameterObject->getUri()),
                $this->getMasterFactory()->createWriteSessionCommand(),
                $this->getMasterFactory()->createStorePreviousUriCommand(),
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createFetchSteamIdFromSessionQuery(),
                $this->getMasterFactory()->createCounterStrikeGateway()
            );
        }

        /**
         * @param RedirectControllerParameterObject $parameterObject
         *
         * @return \Ganked\Skeleton\Controllers\GetController
         */
        public function createRedirectController(RedirectControllerParameterObject $parameterObject)
        {
            $model = new \Ganked\Frontend\Models\PageModel($parameterObject->getUri());
            $model->setRedirect($parameterObject->getRedirect());

            return new \Ganked\Skeleton\Controllers\GetController(
                $model,
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createGetResponseHandler(),
                $this->getMasterFactory()->createGetPostHandler(),
                new HtmlResponse
            );
        }

    }
}
