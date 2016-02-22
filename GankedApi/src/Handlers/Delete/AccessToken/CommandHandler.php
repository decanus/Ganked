<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Delete\AccessToken
{
    use Ganked\API\Commands\DeleteAccessTokenCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Library\ValueObjects\Token;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\Unauthorized;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var DeleteAccessTokenCommand
         */
        private $deleteAccessTokenCommand;

        /**
         * @param DeleteAccessTokenCommand $deleteAccessTokenCommand
         */
        public function __construct(DeleteAccessTokenCommand $deleteAccessTokenCommand)
        {
            $this->deleteAccessTokenCommand = $deleteAccessTokenCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            if (!$request->hasParameter('access_token')) {
                throw new ApiException('Request requires Access Token', 0, null, new Unauthorized);
            }

            $this->deleteAccessTokenCommand->execute(
                new Token(str_replace(' ', '+', $request->getParameter('access_token')))
            );

            $model->setData(['success' => true]);
        }
    }
}
