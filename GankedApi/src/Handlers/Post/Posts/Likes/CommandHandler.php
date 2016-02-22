<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Posts\Likes
{
    use Ganked\API\Commands\LikePostCommand;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\ApiPostModel;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var LikePostCommand
         */
        private $likePostCommand;

        /**
         * @param LikePostCommand $likePostCommand
         */
        public function __construct(LikePostCommand $likePostCommand)
        {
            $this->likePostCommand = $likePostCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         * @throws \InvalidArgumentException
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $postId = explode('/', $request->getUri()->getPath())[2];

            /*** @var $model ApiPostModel */
            $this->likePostCommand->execute($model->getUserId(), $postId);
            $model->setData(['success' => true]);
        }
    }
}
