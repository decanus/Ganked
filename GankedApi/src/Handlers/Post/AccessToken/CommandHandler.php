<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\AccessToken
{
    use Ganked\API\Commands\SaveAccessTokenCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Library\ValueObjects\Token;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var SaveAccessTokenCommand
         */
        private $saveAccessTokenCommand;

        /**
         * @param SaveAccessTokenCommand $saveAccessTokenCommand
         */
        public function __construct(SaveAccessTokenCommand $saveAccessTokenCommand)
        {
            $this->saveAccessTokenCommand = $saveAccessTokenCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         * @throws \RuntimeException
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            if (!$request->hasParameter('userId')) {
                throw new ApiException('User ID needs to be set', 0, null, new BadRequest);
            }

            $token = new Token;

            $this->saveAccessTokenCommand->execute($token, $request->getParameter('userId'));
            $model->setData(['token' => (string) $token]);
        }
    }
}
