<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'ganked\\frontend\\bootstrapper' => '/Bootstrapper.php',
                'ganked\\frontend\\commands\\locksessionforsteamlogincommand' => '/Commands/LockSessionForSteamLoginCommand.php',
                'ganked\\frontend\\commands\\savedefaultleagueoflegendsregioninsessioncommand' => '/Commands/SaveDefaultLeagueOfLegendsRegionInSessionCommand.php',
                'ganked\\frontend\\commands\\savesteamidinsessioncommand' => '/Commands/SaveSteamIdInSessionCommand.php',
                'ganked\\frontend\\controllers\\abstractpagecontroller' => '/Controllers/PageControllers/AbstractPageController.php',
                'ganked\\frontend\\controllers\\abstractsummonerpagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/AbstractSummonerPageController.php',
                'ganked\\frontend\\controllers\\counterstrikeuserpagecontroller' => '/Controllers/PageControllers/CounterStrikeUserPageController.php',
                'ganked\\frontend\\controllers\\matchpagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/MatchPageController.php',
                'ganked\\frontend\\controllers\\pagecontroller' => '/Controllers/PageControllers/PageController.php',
                'ganked\\frontend\\controllers\\passwordrecoverypagecontroller' => '/Controllers/PageControllers/PasswordRecoveryPageController.php',
                'ganked\\frontend\\controllers\\searchpagecontroller' => '/Controllers/PageControllers/SearchPageController.php',
                'ganked\\frontend\\controllers\\staticpagecontroller' => '/Controllers/PageControllers/StaticPageController.php',
                'ganked\\frontend\\controllers\\steamlogincontroller' => '/Controllers/SteamLoginController.php',
                'ganked\\frontend\\controllers\\steamregistrationpagecontroller' => '/Controllers/PageControllers/SteamRegistrationPageController.php',
                'ganked\\frontend\\controllers\\summonerchampionspagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerChampionsPageController.php',
                'ganked\\frontend\\controllers\\summonercomparisonpagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerComparisonPageController.php',
                'ganked\\frontend\\controllers\\summonercurrentgamecontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerCurrentGameController.php',
                'ganked\\frontend\\controllers\\summonermasteriespagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerMasteriesPageController.php',
                'ganked\\frontend\\controllers\\summonermultisearchcontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerMultiSearchController.php',
                'ganked\\frontend\\controllers\\summonerpagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerPageController.php',
                'ganked\\frontend\\controllers\\summonerrunepagecontroller' => '/Controllers/PageControllers/LeagueOfLegends/SummonerRunePageController.php',
                'ganked\\frontend\\controllers\\userprofilepagecontroller' => '/Controllers/PageControllers/UserProfilePageController.php',
                'ganked\\frontend\\dataobjects\\counterstrike\\user' => '/DataObjects/CounterStrike/User.php',
                'ganked\\frontend\\dataobjects\\profile' => '/DataObjects/Profile.php',
                'ganked\\frontend\\dataobjects\\summoner' => '/DataObjects/LeagueOfLegends/Summoner.php',
                'ganked\\frontend\\factories\\commandfactory' => '/Factories/CommandFactory.php',
                'ganked\\frontend\\factories\\controllerfactory' => '/Factories/ControllerFactory.php',
                'ganked\\frontend\\factories\\gatewayfactory' => '/Factories/GatewayFactory.php',
                'ganked\\frontend\\factories\\handlerfactory' => '/Factories/HandlerFactory.php',
                'ganked\\frontend\\factories\\locatorfactory' => '/Factories/LocatorFactory.php',
                'ganked\\frontend\\factories\\mapperfactory' => '/Factories/MapperFactory.php',
                'ganked\\frontend\\factories\\queryfactory' => '/Factories/QueryFactory.php',
                'ganked\\frontend\\factories\\readerfactory' => '/Factories/ReaderFactory.php',
                'ganked\\frontend\\factories\\rendererfactory' => '/Factories/RendererFactory.php',
                'ganked\\frontend\\factories\\routerfactory' => '/Factories/RouterFactory.php',
                'ganked\\frontend\\gateways\\social\\profilegateway' => '/Gateways/Social/ProfileGateway.php',
                'ganked\\frontend\\handlers\\abstractsearchhandler' => '/Handlers/Search/AbstractSearchHandler.php',
                'ganked\\frontend\\handlers\\commandhandler' => '/Handlers/CommandHandler.php',
                'ganked\\frontend\\handlers\\get\\abstractposthandler' => '/Handlers/Get/AbstractPostHandler.php',
                'ganked\\frontend\\handlers\\get\\abstractresponsehandler' => '/Handlers/Get/AbstractResponseHandler.php',
                'ganked\\frontend\\handlers\\get\\account\\queryhandler' => '/Handlers/Get/Account/QueryHandler.php',
                'ganked\\frontend\\handlers\\get\\posthandler' => '/Handlers/Get/PostHandler.php',
                'ganked\\frontend\\handlers\\get\\responsehandler' => '/Handlers/Get/ResponseHandler.php',
                'ganked\\frontend\\handlers\\get\\steam\\connect\\commandhandler' => '/Handlers/Get/Steam/Connect/CommandHandler.php',
                'ganked\\frontend\\handlers\\get\\steam\\connect\\prehandler' => '/Handlers/Get/Steam/Connect/PreHandler.php',
                'ganked\\frontend\\handlers\\get\\steam\\connect\\queryhandler' => '/Handlers/Get/Steam/Connect/QueryHandler.php',
                'ganked\\frontend\\handlers\\get\\transformationhandler' => '/Handlers/Get/TransformationHandler.php',
                'ganked\\frontend\\handlers\\handlerinterface' => '/Handlers/HandlerInterface.php',
                'ganked\\frontend\\handlers\\leagueoflegendssearchhandler' => '/Handlers/Search/LeagueOfLegendsSearchHandler.php',
                'ganked\\frontend\\handlers\\prehandler' => '/Handlers/PreHandler.php',
                'ganked\\frontend\\handlers\\queryhandler' => '/Handlers/QueryHandler.php',
                'ganked\\frontend\\handlers\\transformationhandler' => '/Handlers/TransformationHandler.php',
                'ganked\\frontend\\locators\\rendererlocator' => '/Locators/RendererLocator.php',
                'ganked\\frontend\\mappers\\counterstrikeusermapper' => '/Mappers/CounterStrikeUserMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendscurrentgamemapper' => '/Mappers/LeagueOfLegendsCurrentGameMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendsmatchoverviewmapper' => '/Mappers/LeagueOfLegendsMatchOverviewMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendsmultisearchmapper' => '/Mappers/LeagueOfLegendsMultiSearchMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendsrecentgamesmapper' => '/Mappers/LeagueOfLegendsRecentGamesMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendssummonermapper' => '/Mappers/LeagueOfLegendsSummonerMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendssummonerrolemapper' => '/Mappers/LeagueOfLegendsSummonerRoleMapper.php',
                'ganked\\frontend\\mappers\\leagueoflegendssummonerrunesmapper' => '/Mappers/LeagueOfLegendsSummonerRunesMapper.php',
                'ganked\\frontend\\mappers\\userprofilemapper' => '/Mappers/UserProfileMapper.php',
                'ganked\\frontend\\models\\abstractsummonermodel' => '/Models/LeagueOfLegends/AbstractSummonerModel.php',
                'ganked\\frontend\\models\\accountpagemodel' => '/Models/AccountPageModel.php',
                'ganked\\frontend\\models\\leagueoflegendssearchpagemodel' => '/Models/LeagueOfLegends/LeagueOfLegendsSearchPageModel.php',
                'ganked\\frontend\\models\\matchpagemodel' => '/Models/LeagueOfLegends/MatchPageModel.php',
                'ganked\\frontend\\models\\pagemodel' => '/Models/PageModel.php',
                'ganked\\frontend\\models\\passwordrecoverypagemodel' => '/Models/PasswordRecoveryPageModel.php',
                'ganked\\frontend\\models\\searchpagemodel' => '/Models/SearchPageModel.php',
                'ganked\\frontend\\models\\staticpagemodel' => '/Models/StaticPageModel.php',
                'ganked\\frontend\\models\\steamconnectmodel' => '/Models/Steam/SteamConnectModel.php',
                'ganked\\frontend\\models\\steamregistrationpagemodel' => '/Models/Steam/SteamRegistrationPageModel.php',
                'ganked\\frontend\\models\\steamuserpagemodel' => '/Models/Steam/SteamUserPageModel.php',
                'ganked\\frontend\\models\\summonerchampionspagemodel' => '/Models/LeagueOfLegends/SummonerChampionsPageModel.php',
                'ganked\\frontend\\models\\summonercomparisonpagemodel' => '/Models/LeagueOfLegends/SummonerComparisonPageModel.php',
                'ganked\\frontend\\models\\summonercurrentgamepagemodel' => '/Models/LeagueOfLegends/SummonerCurrentGamePageModel.php',
                'ganked\\frontend\\models\\summonermasteriespagemodel' => '/Models/LeagueOfLegends/SummonerMasteriesPageModel.php',
                'ganked\\frontend\\models\\summonerpagemodel' => '/Models/LeagueOfLegends/SummonerPageModel.php',
                'ganked\\frontend\\models\\summonerrunespagemodel' => '/Models/LeagueOfLegends/SummonerRunesPageModel.php',
                'ganked\\frontend\\models\\userprofilemodel' => '/Models/UserProfileModel.php',
                'ganked\\frontend\\parameterobjects\\abstractcontrollerparameterobject' => '/ParameterObjects/AbstractControllerParameterObject.php',
                'ganked\\frontend\\parameterobjects\\controllerparameterobject' => '/ParameterObjects/ControllerParameterObject.php',
                'ganked\\frontend\\parameterobjects\\redirectcontrollerparameterobject' => '/ParameterObjects/RedirectControllerParameterObject.php',
                'ganked\\frontend\\queries\\abstractleagueoflegendsquery' => '/Queries/LeagueOfLegends/AbstractLeagueOfLegendsQuery.php',
                'ganked\\frontend\\queries\\fetchdefaultleagueoflegendsregionfromsessionquery' => '/Queries/LeagueOfLegends/FetchDefaultLeagueOfLegendsRegionFromSessionQuery.php',
                'ganked\\frontend\\queries\\fetchmasteriesforsummonerquery' => '/Queries/LeagueOfLegends/FetchMasteriesForSummonerQuery.php',
                'ganked\\frontend\\queries\\fetchmatchlistsforsummonersinregionbyusernamequery' => '/Queries/LeagueOfLegends/FetchMatchlistsForSummonersInRegionByUsernameQuery.php',
                'ganked\\frontend\\queries\\fetchplayerbansquery' => '/Queries/Steam/FetchPlayerBansQuery.php',
                'ganked\\frontend\\queries\\fetchrankedstatsforsummonerquery' => '/Queries/LeagueOfLegends/FetchRankedStatsForSummonerQuery.php',
                'ganked\\frontend\\queries\\fetchrecentgamesforsummonerquery' => '/Queries/LeagueOfLegends/FetchRecentGamesForSummonerQuery.php',
                'ganked\\frontend\\queries\\fetchrunesforsummonerquery' => '/Queries/LeagueOfLegends/FetchRunesForSummonerQuery.php',
                'ganked\\frontend\\queries\\fetchsummonercomparisonstatsquery' => '/Queries/LeagueOfLegends/FetchSummonerComparisonStatsQuery.php',
                'ganked\\frontend\\queries\\fetchsummonercurrentgamequery' => '/Queries/LeagueOfLegends/FetchSummonerCurrentGameQuery.php',
                'ganked\\frontend\\queries\\fetchsummonerforregionbynamequery' => '/Queries/LeagueOfLegends/FetchSummonerForRegionByNameQuery.php',
                'ganked\\frontend\\queries\\fetchsummonersbynamequery' => '/Queries/LeagueOfLegends/FetchSummonersByNameQuery.php',
                'ganked\\frontend\\queries\\fetchuserfavouritesummonersquery' => '/Queries/LeagueOfLegends/FetchUserFavouriteSummonersQuery.php',
                'ganked\\frontend\\queries\\hasdefaultleagueoflegendsregionfromsessionquery' => '/Queries/LeagueOfLegends/HasDefaultLeagueOfLegendsRegionFromSessionQuery.php',
                'ganked\\frontend\\queries\\hasuserfavouritedsummonerquery' => '/Queries/LeagueOfLegends/HasUserFavouritedSummonerQuery.php',
                'ganked\\frontend\\queries\\resolvevanityurlquery' => '/Queries/Steam/ResolveVanityUrlQuery.php',
                'ganked\\frontend\\queries\\social\\fetchprofileforusernamequery' => '/Queries/Social/FetchProfileForUsernameQuery.php',
                'ganked\\frontend\\queries\\social\\hasprofileforusernamequery' => '/Queries/Social/HasProfileForUsernameQuery.php',
                'ganked\\frontend\\queries\\summonermultisearchquery' => '/Queries/LeagueOfLegends/SummonerMultiSearchQuery.php',
                'ganked\\frontend\\readers\\counterstrikereader' => '/Readers/CounterStrikeReader.php',
                'ganked\\frontend\\readers\\leagueoflegendsreader' => '/Readers/LeagueOfLegendsReader.php',
                'ganked\\frontend\\readers\\urlredirectreader' => '/Readers/UrlRedirectReader.php',
                'ganked\\frontend\\readers\\userreader' => '/Readers/UserReader.php',
                'ganked\\frontend\\renderers\\abstractpagerenderer' => '/Renderers/Pages/AbstractPageRenderer.php',
                'ganked\\frontend\\renderers\\abstractrowrenderer' => '/Renderers/Snippets/Rows/AbstractRowRenderer.php',
                'ganked\\frontend\\renderers\\abstractsnippetrenderer' => '/Renderers/Snippets/AbstractSnippetRenderer.php',
                'ganked\\frontend\\renderers\\abstractsummonerpagerenderer' => '/Renderers/Pages/LeagueOfLegends/AbstractSummonerPageRenderer.php',
                'ganked\\frontend\\renderers\\accountpagerenderer' => '/Renderers/Pages/AccountPageRenderer.php',
                'ganked\\frontend\\renderers\\appendcsrftokensnippetrenderer' => '/Renderers/Snippets/AppendCSRFTokenSnippetRenderer.php',
                'ganked\\frontend\\renderers\\bargraphrenderer' => '/Renderers/Snippets/BarGraphRenderer.php',
                'ganked\\frontend\\renderers\\boolrowrenderer' => '/Renderers/Snippets/Rows/BoolRowRenderer.php',
                'ganked\\frontend\\renderers\\counterstrikeuserpagerenderer' => '/Renderers/Pages/Steam/CounterStrikeUserPageRenderer.php',
                'ganked\\frontend\\renderers\\definitionblocksnippetrenderer' => '/Renderers/Snippets/DefinitionBlockSnippetRenderer.php',
                'ganked\\frontend\\renderers\\genericpagerenderer' => '/Renderers/Pages/GenericPageRenderer.php',
                'ganked\\frontend\\renderers\\headersnippetrenderer' => '/Renderers/Snippets/HeaderSnippetRenderer.php',
                'ganked\\frontend\\renderers\\infobarrenderer' => '/Renderers/Snippets/InfoBarRenderer.php',
                'ganked\\frontend\\renderers\\leagueoflegendsbannedchampionsrenderer' => '/Renderers/Snippets/LeagueOfLegendsBannedChampionsRenderer.php',
                'ganked\\frontend\\renderers\\leagueoflegendschampiontooltiprenderer' => '/Renderers/Snippets/LeagueOfLegendsChampionTooltipRenderer.php',
                'ganked\\frontend\\renderers\\leagueoflegendsrunessnippetrenderer' => '/Renderers/Snippets/LeagueOfLegendsRunesSnippetRenderer.php',
                'ganked\\frontend\\renderers\\leagueoflegendssearchbarrenderer' => '/Renderers/Snippets/LeagueOfLegendsSearchBarRenderer.php',
                'ganked\\frontend\\renderers\\leagueoflegendssearchpagerenderer' => '/Renderers/Pages/LeagueOfLegends/LeagueOfLegendsSearchPageRenderer.php',
                'ganked\\frontend\\renderers\\masteriessnippetrenderer' => '/Renderers/Snippets/MasteriesSnippetRenderer.php',
                'ganked\\frontend\\renderers\\matchpagerenderer' => '/Renderers/Pages/LeagueOfLegends/MatchPageRenderer.php',
                'ganked\\frontend\\renderers\\metatagssnippetsrenderer' => '/Renderers/Snippets/MetaTagsSnippetsRenderer.php',
                'ganked\\frontend\\renderers\\numberrowrenderer' => '/Renderers/Snippets/Rows/NumberRowRenderer.php',
                'ganked\\frontend\\renderers\\passwordrecoverypagerenderer' => '/Renderers/Pages/PasswordRecoveryPageRenderer.php',
                'ganked\\frontend\\renderers\\recentsummonersrenderer' => '/Renderers/Snippets/RecentSummonersRenderer.php',
                'ganked\\frontend\\renderers\\signinlinkssnippetrenderer' => '/Renderers/Snippets/SignInLinksSnippetRenderer.php',
                'ganked\\frontend\\renderers\\staticpagerenderer' => '/Renderers/Pages/StaticPageRenderer.php',
                'ganked\\frontend\\renderers\\steamconnectrenderer' => '/Renderers/Pages/Steam/SteamConnectRenderer.php',
                'ganked\\frontend\\renderers\\steamloginpagerenderer' => '/Renderers/Pages/Steam/SteamLoginPageRenderer.php',
                'ganked\\frontend\\renderers\\steamopenidlinkrenderer' => '/Renderers/Snippets/SteamOpenIdLinkRenderer.php',
                'ganked\\frontend\\renderers\\steamregistrationpagerenderer' => '/Renderers/Pages/Steam/SteamRegistrationPageRenderer.php',
                'ganked\\frontend\\renderers\\summonerchampionspagerenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerChampionsPageRenderer.php',
                'ganked\\frontend\\renderers\\summonercomparisonpagerenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerComparisonPageRenderer.php',
                'ganked\\frontend\\renderers\\summonercurrentgamepagerenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerCurrentGamePageRenderer.php',
                'ganked\\frontend\\renderers\\summonermasteriespagerenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerMasteriesPageRenderer.php',
                'ganked\\frontend\\renderers\\summonermultisearchrenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerMultiSearchRenderer.php',
                'ganked\\frontend\\renderers\\summonerpagerenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerPageRenderer.php',
                'ganked\\frontend\\renderers\\summonerrunespagepagerenderer' => '/Renderers/Pages/LeagueOfLegends/SummonerRunesPageRenderer.php',
                'ganked\\frontend\\renderers\\summonersidebarrenderer' => '/Renderers/Snippets/SummonerSidebarRenderer.php',
                'ganked\\frontend\\renderers\\summonersnippetrenderer' => '/Renderers/Snippets/SummonerSnippetRenderer.php',
                'ganked\\frontend\\renderers\\trackingsnippetrenderer' => '/Renderers/Snippets/TrackingSnippetRenderer.php',
                'ganked\\frontend\\renderers\\userprofilepagerenderer' => '/Renderers/Pages/UserProfilePageRenderer.php',
                'ganked\\frontend\\routers\\accountpagerouter' => '/Routers/AccountPageRouter.php',
                'ganked\\frontend\\routers\\counterstrikepagerouter' => '/Routers/CounterStrikePageRouter.php',
                'ganked\\frontend\\routers\\errorpagerouter' => '/Routers/ErrorPageRouter.php',
                'ganked\\frontend\\routers\\leagueoflegendspagerouter' => '/Routers/LeagueOfLegendsPageRouter.php',
                'ganked\\frontend\\routers\\redirectrouter' => '/Routers/RedirectRouter.php',
                'ganked\\frontend\\routers\\searchpagerouter' => '/Routers/SearchPageRouter.php',
                'ganked\\frontend\\routers\\staticpagerouter' => '/Routers/StaticPageRouter.php',
                'ganked\\frontend\\routers\\steamloginrouter' => '/Routers/SteamLoginRouter.php',
                'ganked\\frontend\\routers\\userpagerouter' => '/Routers/UserPageRouter.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
