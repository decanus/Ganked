<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Delete\LeagueOfLegends\SummonerFavourite
{

    use Ganked\API\Commands\UnfavouriteSummonerCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var UnfavouriteSummonerCommand
         */
        private $unfavouriteSummonerCommand;

        /**
         * @param UnfavouriteSummonerCommand $unfavouriteSummonerCommand
         */
        public function __construct(UnfavouriteSummonerCommand $unfavouriteSummonerCommand)
        {
            $this->unfavouriteSummonerCommand = $unfavouriteSummonerCommand;
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
                $this->unfavouriteSummonerCommand->execute(
                    new \MongoId($request->getUri()->getExplodedPath()[1]),
                    $request->getParameter('summonerId'),
                    new Region($request->getParameter('region'))
                );
                $model->setData(['success' => true]);
            } catch (\Exception $e) {
                $model->setData(['success' => false]);
            }
        }
    }
}
