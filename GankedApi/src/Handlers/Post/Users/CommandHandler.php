<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Users
{
    use Ganked\API\Commands\InsertUserCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var InsertUserCommand
         */
        private $insertUserCommand;

        /**
         * @param InsertUserCommand $insertUserCommand
         */
        public function __construct(InsertUserCommand $insertUserCommand)
        {
            $this->insertUserCommand = $insertUserCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         * @throws \InvalidArgumentException
         * @throws \RuntimeException
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            if (!$request->hasParameter('email')) {
                throw new ApiException('Missing parameter: email', 0, null, new BadRequest);
            }

            if (!$request->hasParameter('username')) {
                throw new ApiException('Missing parameter: username', 0, null, new BadRequest);
            }

            if (!$request->hasParameter('hash')) {
                throw new ApiException('Missing parameter: hash', 0, null, new BadRequest);
            }

            $steamId = '';
            if ($request->hasParameter('steamId')) {
                $steamId = $request->getParameter('steamId');
            }

            if ($steamId === '') {

                if (!$request->hasParameter('firstname')) {
                    throw new ApiException('Missing parameter: firstname', 0, null, new BadRequest);
                }

                if (!$request->hasParameter('lastname')) {
                    throw new ApiException('Missing parameter: lastname', 0, null, new BadRequest);
                }
                if (!$request->hasParameter('password')) {
                    throw new ApiException('Missing parameter: password', 0, null, new BadRequest);
                }

                if (!$request->hasParameter('salt')) {
                    throw new ApiException('Missing parameter: salt', 0, null, new BadRequest);
                }
            }

            $data = [
                'email' => $request->getParameter('email'),
                'username' => $request->getParameter('username'),
                'hash' => $request->getParameter('hash'),
            ];

            if ($steamId === '') {
                $data['firstname'] = $request->getParameter('firstname');
                $data['lastname'] = $request->getParameter('lastname');
                $data['password'] = $request->getParameter('password');
                $data['salt'] = $request->getParameter('salt');
            } else {

                $steamName = '';
                if ($request->hasParameter('steamName')) {
                    $steamName = $request->getParameter('steamName');
                }

                $data['steamIds'][] = ['id' => $steamId, 'name' => $steamName, 'type' => 'main'];
            }

            $result = $this->insertUserCommand->execute($data);

            $model->setObjectType('users');
            $model->setData($result);
        }
    }
}
