<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get\Steam\Connect
{

    use Ganked\Frontend\Commands\SaveSteamIdInSessionCommand;
    use Ganked\Frontend\Models\SteamConnectModel;
    use Ganked\Skeleton\Handlers\CommandHandlerInterface;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var SaveSteamIdInSessionCommand
         */
        private $saveSteamIdInSessionCommand;

        /**
         * @param SaveSteamIdInSessionCommand $saveSteamIdInSessionCommand
         */
        public function __construct(
            SaveSteamIdInSessionCommand $saveSteamIdInSessionCommand
        )
        {
            $this->saveSteamIdInSessionCommand = $saveSteamIdInSessionCommand;
        }

        /**
         * @param AbstractRequest     $request
         * @param SteamConnectModel   $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model)
        {
            if (!$model->hasClaimedId()) {
                return;
            }

            $this->saveSteamIdInSessionCommand->execute($model->getClaimedId());
        }
    }
}
