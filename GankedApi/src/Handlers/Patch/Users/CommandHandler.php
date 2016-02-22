<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Patch\Users
{
    use Ganked\API\Commands\UpdateUserCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;
    use Ganked\Skeleton\Http\StatusCodes\InternalServerError;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var UpdateUserCommand
         */
        private $updateUserCommand;

        /**
         * @param UpdateUserCommand $updateUserCommand
         */
        public function __construct(UpdateUserCommand $updateUserCommand)
        {
            $this->updateUserCommand = $updateUserCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $parameters = $request->getParameters();
            $id = new \MongoId($parameters['data']['id']);

            $attributes = $parameters['data']['attributes'];

            unset(
                $attributes['hash'],
                $attributes['password'],
                $attributes['salt'],
                $attributes['id'],
                $attributes['username'],
                $attributes['password'],
                $attributes['verified'],
                $attributes['profile_type']
            );

            if (empty($attributes)) {
                throw new ApiException('Nothing to update', 0, null, new BadRequest);
            }

            $result = $this->updateUserCommand->execute($id, $attributes);

            if (!$result) {
                throw new ApiException('Unknown error', 0, null, new InternalServerError);
            }
        }
    }
}
