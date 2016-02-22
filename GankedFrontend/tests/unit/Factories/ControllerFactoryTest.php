<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Frontend\ParameterObjects\ControllerParameterObject;
    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;

    /**
     * @covers Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses Ganked\Frontend\Controllers\AbstractPageController
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses Ganked\Frontend\Renderers\StaticPageRenderer
     * @uses Ganked\Frontend\Controllers\SearchPageController
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Frontend\Factories\ReaderFactory
     * @uses Ganked\Frontend\Factories\LocatorFactory
     * @uses Ganked\Frontend\Factories\CommandFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Skeleton\Session\Session
     * @uses Ganked\Library\Helpers\DomHelper
     * @uses Ganked\Skeleton\Backends\Wrappers\Curl
     * @uses Ganked\Frontend\Queries\FetchSummonersByNameQuery
     * @uses \Ganked\Frontend\Controllers\SummonerPageController
     * @uses \Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery
     * @uses \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
     * @uses \Ganked\Frontend\Renderers\SummonerPageRenderer
     * @uses \Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsSearchPageRenderer
     * @uses \Ganked\Frontend\Factories\MapperFactory
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Controllers\StaticPageController
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper
     * @uses \Ganked\Frontend\Controllers\UserProfilePageController
     * @uses \Ganked\Frontend\Controllers\PasswordRecoveryPageController
     * @uses \Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper
     * @uses \Ganked\Frontend\Locators\RendererLocator
     * @uses \Ganked\Frontend\Renderers\AbstractSummonerPageRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerSidebarRenderer
     * @uses \Ganked\Frontend\Controllers\SummonerMultiSearchController
     * @uses \Ganked\Frontend\Controllers\SummonerMasteriesPageController
     * @uses \Ganked\Frontend\Controllers\SummonerRunePageController
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper
     * @uses \Ganked\Frontend\Queries\FetchMatchlistsForSummonersInRegionByUsernameQuery
     * @uses \Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper
     * @uses \Ganked\Frontend\Queries\FetchRunesForSummonerQuery
     * @uses \Ganked\Frontend\Controllers\AbstractSummonerPageController
     * @uses \Ganked\Frontend\Queries\SummonerMultiSearchQuery
     * @uses \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsSearchBarRenderer
     * @uses \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand
     * @uses \Ganked\Frontend\Renderers\SummonerMultiSearchRenderer
     * @uses \Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery
     * @uses \Ganked\Frontend\Renderers\SummonerCurrentGamePageRenderer
     * @uses \Ganked\Frontend\Controllers\SummonerCurrentGameController
     * @uses \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerSnippetRenderer
     * @uses \Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery
     * @uses \Ganked\Frontend\Queries\AbstractLeagueOfLegendsQuery
     * @uses \Ganked\Frontend\Renderers\MasteriesSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\SummonerMasteriesPageRenderer
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsBannedChampionsRenderer
     * @uses \Ganked\Frontend\Renderers\LeagueOfLegendsRunesSnippetRenderer
     * @uses \Ganked\Frontend\Mappers\LeagueOfLegendsCurrentGameMapper
     * @uses \Ganked\Frontend\Renderers\SummonerRunesPagePageRenderer
     * @uses \Ganked\Frontend\Commands\SaveSteamIdInSessionCommand
     * @uses \Ganked\Frontend\Commands\LockSessionForSteamLoginCommand
     * @uses \Ganked\Frontend\Controllers\SteamRegistrationPageController
     * @uses \Ganked\Frontend\Controllers\SteamLoginController
     * @uses \Ganked\Frontend\Controllers\CounterStrikeUserPageController
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     * @uses \Ganked\Frontend\Queries\ResolveVanityUrlQuery
     * @uses \Ganked\Frontend\Queries\FetchPlayerBansQuery
     * @uses \Ganked\Frontend\Renderers\CounterStrikeUserPageRenderer
     * @uses \Ganked\Frontend\Renderers\AccountPageRenderer
     * @uses \Ganked\Frontend\Handlers\Get\TransformationHandler
     * @uses \Ganked\Frontend\Handlers\Get\Account\QueryHandler
     * @uses \Ganked\Frontend\Renderers\SteamOpenIdLinkRenderer
     */
    class ControllerFactoryTest extends GenericFactoryTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @param       $method
         * @param       $instance
         * @param array $model
         *
         * @throws \PHPUnit_Framework_Exception
         * @dataProvider provideLegacyInstanceNames
         */
        public function testCreateLegacyInstanceWorks($method, $instance, $model)
        {
            $modelMock = $this->getMockBuilder($model)
                ->disableOriginalConstructor()
                ->getMock();

            $modelMock->expects($this->any())
                ->method('getTemplatePath')
                ->will($this->returnValue('templates://pages/test.xhtml'));
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $modelMock->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue($uri));

            $this->assertInstanceOf($instance, call_user_func_array([$this->getMasterFactory(), $method], [$modelMock]));
        }

        /**
         * @return array
         */
        public function provideLegacyInstanceNames()
        {
            return [
                ['createLeagueOfLegendsSearchPageController', \Ganked\Frontend\Controllers\SearchPageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createStaticPageController', \Ganked\Frontend\Controllers\StaticPageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createSummonerPageController', \Ganked\Frontend\Controllers\SummonerPageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createUserProfilePageController', \Ganked\Frontend\Controllers\UserProfilePageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createPasswordRecoveryController', \Ganked\Frontend\Controllers\PasswordRecoveryPageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createSummonerRunePageController', \Ganked\Frontend\Controllers\SummonerRunePageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createSummonerMasteriesPageController', \Ganked\Frontend\Controllers\SummonerMasteriesPageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createLeagueOfLegendsSearchMultiPageController', \Ganked\Frontend\Controllers\SummonerMultiSearchController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createSummonerCurrentGamePageController', \Ganked\Frontend\Controllers\SummonerCurrentGameController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createSteamRegistrationController', \Ganked\Frontend\Controllers\SteamRegistrationPageController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
                ['createSteamLoginController', \Ganked\Frontend\Controllers\SteamLoginController::class, \Ganked\Frontend\ParameterObjects\ControllerParameterObject::class],
            ];
        }

        /**
         * @param                                   $method
         * @param                                   $instance
         * @param RedirectControllerParameterObject $parameterObject
         *
         * @throws \PHPUnit_Framework_Exception
         * @dataProvider provideInstanceNames
         */
        public function testCreateInstanceWorks($method, $instance, $parameterObject)
        {
            $this->assertInstanceOf($instance, call_user_func_array([$this->getMasterFactory(), $method], [$parameterObject]));
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createRedirectController', \Ganked\Skeleton\Controllers\GetController::class, new RedirectControllerParameterObject(new Uri('ganked.net'), new RedirectToPath(new Uri('ganked.net'), new MovedTemporarily, '/'))],
                ['createAccountPageController', \Ganked\Skeleton\Controllers\GetController::class, new ControllerParameterObject(new Uri('ganked.net'))],
                ['createCounterStrikeUserPageController', \Ganked\Frontend\Controllers\CounterStrikeUserPageController::class, new ControllerParameterObject(new Uri('ganked.net'))],

            ];
        }
    }
}
