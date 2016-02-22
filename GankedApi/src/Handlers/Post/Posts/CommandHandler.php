<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Post\Posts
{

    use Ganked\API\Commands\InsertPostCommand;
    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\CommandHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\ApiPostModel;
    use Ganked\API\Parsers\PostParser;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var PostParser
         */
        private $postParser;

        /**
         * @var InsertPostCommand
         */
        private $insertPostCommand;

        /**
         * @param PostParser        $postParser
         * @param InsertPostCommand $insertPostCommand
         */
        public function __construct(
            PostParser $postParser,
            InsertPostCommand $insertPostCommand
        )
        {
            $this->postParser = $postParser;
            $this->insertPostCommand = $insertPostCommand;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            if (!$request->hasParameter('message')) {
                throw new ApiException('Message is required to create post', 0, null, new BadRequest);
            }

            $post = $this->postParser->parse($request->getParameter('message'));

            /**
             * @var $model ApiPostModel
             */
            $post['user'] = $request->getParameter('userId');
            $post['created'] = (new \DateTime('now'))->format('c');
            $post['source'] = 'web';

            $result = $this->insertPostCommand->execute($post);

            $model->setData($result);
        }
    }
}
