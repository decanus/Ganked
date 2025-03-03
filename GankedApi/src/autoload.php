<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'ganked\\api\\bootstrapper' => '/Bootstrapper.php',
                'ganked\\api\\commands\\addsteamaccounttousercommand' => '/Commands/AddSteamAccountToUserCommand.php',
                'ganked\\api\\commands\\deleteaccesstokencommand' => '/Commands/DeleteAccessTokenCommand.php',
                'ganked\\api\\commands\\favouritesummonercommand' => '/Commands/FavouriteSummonerCommand.php',
                'ganked\\api\\commands\\insertpostcommand' => '/Commands/InsertPostCommand.php',
                'ganked\\api\\commands\\insertusercommand' => '/Commands/InsertUserCommand.php',
                'ganked\\api\\commands\\likepostcommand' => '/Commands/LikePostCommand.php',
                'ganked\\api\\commands\\saveaccesstokencommand' => '/Commands/SaveAccessTokenCommand.php',
                'ganked\\api\\commands\\unfavouritesummonercommand' => '/Commands/UnfavouriteSummonerCommand.php',
                'ganked\\api\\commands\\updateusercommand' => '/Commands/UpdateUserCommand.php',
                'ganked\\api\\controllers\\abstractapicontroller' => '/Controllers/AbstractApiController.php',
                'ganked\\api\\controllers\\errorcontroller' => '/Controllers/ErrorController.php',
                'ganked\\api\\controllers\\getcontroller' => '/Controllers/GetController.php',
                'ganked\\api\\controllers\\postcontroller' => '/Controllers/PostController.php',
                'ganked\\api\\exceptions\\apiexception' => '/Exceptions/ApiException.php',
                'ganked\\api\\factories\\backendfactory' => '/Factories/BackendFactory.php',
                'ganked\\api\\factories\\commandfactory' => '/Factories/CommandFactory.php',
                'ganked\\api\\factories\\controllerfactory' => '/Factories/ControllerFactory.php',
                'ganked\\api\\factories\\handlerfactory' => '/Factories/HandlerFactory.php',
                'ganked\\api\\factories\\queryfactory' => '/Factories/QueryFactory.php',
                'ganked\\api\\factories\\readerfactory' => '/Factories/ReaderFactory.php',
                'ganked\\api\\factories\\routerfactory' => '/Factories/RouterFactory.php',
                'ganked\\api\\factories\\servicefactory' => '/Factories/ServiceFactory.php',
                'ganked\\api\\handlers\\abstractresponsehandler' => '/Handlers/AbstractResponseHandler.php',
                'ganked\\api\\handlers\\commandhandler' => '/Handlers/CommandHandler.php',
                'ganked\\api\\handlers\\commandhandlerinterface' => '/Handlers/CommandHandlerInterface.php',
                'ganked\\api\\handlers\\delete\\accesstoken\\commandhandler' => '/Handlers/Delete/AccessToken/CommandHandler.php',
                'ganked\\api\\handlers\\delete\\leagueoflegends\\summonerfavourite\\commandhandler' => '/Handlers/Delete/LeagueOfLegends/SummonerFavourite/CommandHandler.php',
                'ganked\\api\\handlers\\get\\account\\queryhandler' => '/Handlers/Get/Account/QueryHandler.php',
                'ganked\\api\\handlers\\get\\leagueoflegends\\summonerfavourite\\queryhandler' => '/Handlers/Get/LeagueOfLegends/SummonerFavourite/QueryHandler.php',
                'ganked\\api\\handlers\\get\\leagueoflegends\\summonerfavourite\\relationship\\queryhandler' => '/Handlers/Get/LeagueOfLegends/SummonerFavourite/Relationship/QueryHandler.php',
                'ganked\\api\\handlers\\get\\leagueoflegends\\summonerfavourite\\relationship\\responsehandler' => '/Handlers/Get/LeagueOfLegends/SummonerFavourite/Relationship/ResponseHandler.php',
                'ganked\\api\\handlers\\get\\leagueoflegends\\summonerfavourite\\responsehandler' => '/Handlers/Get/LeagueOfLegends/SummonerFavourite/ResponseHandler.php',
                'ganked\\api\\handlers\\get\\posts\\queryhandler' => '/Handlers/Get/Posts/QueryHandler.php',
                'ganked\\api\\handlers\\get\\users\\posts\\queryhandler' => '/Handlers/Get/Users/Posts/QueryHandler.php',
                'ganked\\api\\handlers\\get\\users\\queryhandler' => '/Handlers/Get/Users/QueryHandler.php',
                'ganked\\api\\handlers\\patch\\users\\commandhandler' => '/Handlers/Patch/Users/CommandHandler.php',
                'ganked\\api\\handlers\\patch\\users\\queryhandler' => '/Handlers/Patch/Users/QueryHandler.php',
                'ganked\\api\\handlers\\post\\accesstoken\\commandhandler' => '/Handlers/Post/AccessToken/CommandHandler.php',
                'ganked\\api\\handlers\\post\\authenticate\\queryhandler' => '/Handlers/Post/Authenticate/QueryHandler.php',
                'ganked\\api\\handlers\\post\\leagueoflegends\\summonerfavourite\\commandhandler' => '/Handlers/Post/LeagueOfLegends/SummonerFavourite/CommandHandler.php',
                'ganked\\api\\handlers\\post\\posts\\commandhandler' => '/Handlers/Post/Posts/CommandHandler.php',
                'ganked\\api\\handlers\\post\\posts\\likes\\commandhandler' => '/Handlers/Post/Posts/Likes/CommandHandler.php',
                'ganked\\api\\handlers\\post\\posts\\likes\\queryhandler' => '/Handlers/Post/Posts/Likes/QueryHandler.php',
                'ganked\\api\\handlers\\post\\posts\\queryhandler' => '/Handlers/Post/Posts/QueryHandler.php',
                'ganked\\api\\handlers\\post\\steamaccount\\commandhandler' => '/Handlers/Post/SteamAccount/CommandHandler.php',
                'ganked\\api\\handlers\\post\\users\\commandhandler' => '/Handlers/Post/Users/CommandHandler.php',
                'ganked\\api\\handlers\\prehandler' => '/Handlers/PreHandler.php',
                'ganked\\api\\handlers\\queryhandler' => '/Handlers/QueryHandler.php',
                'ganked\\api\\handlers\\queryhandlerinterface' => '/Handlers/QueryHandlerInterface.php',
                'ganked\\api\\handlers\\responsehandler' => '/Handlers/ResponseHandler.php',
                'ganked\\api\\http\\request\\deleterequest' => '/Http/Request/DeleteRequest.php',
                'ganked\\api\\http\\request\\patchrequest' => '/Http/Request/PatchRequest.php',
                'ganked\\api\\http\\request\\putrequest' => '/Http/Request/PutRequest.php',
                'ganked\\api\\models\\apimodel' => '/Models/ApiModel.php',
                'ganked\\api\\models\\apipostmodel' => '/Models/ApiPostModel.php',
                'ganked\\api\\models\\mongocursormodel' => '/Models/MongoCursorModel.php',
                'ganked\\api\\parsers\\postparser' => '/Parsers/PostParser.php',
                'ganked\\api\\queries\\fetchaccountwithemailquery' => '/Queries/FetchAccountWithEmailQuery.php',
                'ganked\\api\\queries\\fetchaccountwithusernamequery' => '/Queries/FetchAccountWithUsernameQuery.php',
                'ganked\\api\\queries\\fetchfavouritesummonersforuserquery' => '/Queries/FetchFavouriteSummonersForUserQuery.php',
                'ganked\\api\\queries\\fetchpostsbyidsquery' => '/Queries/FetchPostsByIdsQuery.php',
                'ganked\\api\\queries\\fetchsummonersfromredisquery' => '/Queries/FetchSummonersFromRedisQuery.php',
                'ganked\\api\\queries\\fetchuserbyidquery' => '/Queries/FetchUserByIdQuery.php',
                'ganked\\api\\queries\\fetchuserbysteamidquery' => '/Queries/FetchUserBySteamIdQuery.php',
                'ganked\\api\\queries\\fetchuseridforaccesstokenquery' => '/Queries/FetchUserIdForAccessTokenQuery.php',
                'ganked\\api\\queries\\getpostbyidquery' => '/Queries/GetPostByIdQuery.php',
                'ganked\\api\\queries\\getpostsforuserquery' => '/Queries/GetPostsForUserQuery.php',
                'ganked\\api\\queries\\getuserfromdatabasequery' => '/Queries/GetUserFromDatabaseQuery.php',
                'ganked\\api\\queries\\haspostbyidquery' => '/Queries/HasPostByIdQuery.php',
                'ganked\\api\\queries\\hasuserbyidquery' => '/Queries/HasUserByIdQuery.php',
                'ganked\\api\\queries\\isfavouritingsummonerquery' => '/Queries/IsFavouritingSummonerQuery.php',
                'ganked\\api\\readers\\tokenreader' => '/Readers/TokenReader.php',
                'ganked\\api\\routers\\deleterequestrouter' => '/Routers/DeleteRequestRouter.php',
                'ganked\\api\\routers\\getrequestrouter' => '/Routers/GetRequestRouter.php',
                'ganked\\api\\routers\\patchrequestrouter' => '/Routers/PatchRequestRouter.php',
                'ganked\\api\\routers\\postrequestrouter' => '/Routers/PostRequestRouter.php',
                'ganked\\api\\services\\abstractdatabaseservice' => '/Services/AbstractDatabaseService.php',
                'ganked\\api\\services\\favouritesservice' => '/Services/FavouritesService.php',
                'ganked\\api\\services\\postsservice' => '/Services/PostsService.php',
                'ganked\\api\\services\\userservice' => '/Services/UserService.php'
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
