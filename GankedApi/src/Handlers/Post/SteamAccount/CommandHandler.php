<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Post\SteamAccount
{

    use Ganked\API\Commands\AddSteamAccountToUserCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var AddSteamAccountToUserCommand
         */
        private $addSteamAccountToUserCommand;

        /**
         * @param AddSteamAccountToUserCommand $addSteamAccountToUserCommand
         */
        public function __construct(AddSteamAccountToUserCommand $addSteamAccountToUserCommand)
        {
            $this->addSteamAccountToUserCommand = $addSteamAccountToUserCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            if (!$request->hasParameter('steamId')) {
                throw new ApiException('Missing parameter: steamId', 0, null, new BadRequest);
            }

            if (!$request->hasParameter('steamName')) {
                throw new ApiException('Missing parameter: steamName', 0, null, new BadRequest);
            }

            $exploded = $request->getUri()->getExplodedPath();

            try {
                $result = $this->addSteamAccountToUserCommand->execute(
                    new \MongoId($exploded[1]),
                    new SteamId($request->getParameter('steamId')),
                    $request->getParameter('steamName')
                );
            } catch (\Exception $e) {
                $model->setData(['success' => false]);
                return;
            }

            if (!$result) {
                throw new ApiException('Could not be written', 0, null, new BadRequest);
            }

            $model->setData(['success' => true]);
        }
    }
}
