<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Post\LeagueOfLegends\SummonerFavourite
{

    use Ganked\API\Commands\FavouriteSummonerCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var FavouriteSummonerCommand
         */
        private $favouriteSummonerCommand;

        /**
         * @param FavouriteSummonerCommand $favouriteSummonerCommand
         */
        public function __construct(FavouriteSummonerCommand $favouriteSummonerCommand)
        {
            $this->favouriteSummonerCommand = $favouriteSummonerCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            if (!$request->hasParameter('summonerId')) {
                throw new ApiException('Summoner Id is required', 0, null, new BadRequest);
            }

            if (!$request->hasParameter('region')) {
                throw new ApiException('Region is required', 0, null, new BadRequest);
            }

            try {
                $result = $this->favouriteSummonerCommand->execute(
                    new \MongoId($request->getUri()->getExplodedPath()[1]),
                    $request->getParameter('summonerId'),
                    new Region($request->getParameter('region'))
                );
            } catch (\Exception $e) {
                throw new ApiException('Invalid parameter', 0, $e, new BadRequest);
            }

            if (!$result) {
                throw new ApiException('Could not be written', 0, null, new BadRequest);
            }

            $model->setData($result);
        }
    }
}
