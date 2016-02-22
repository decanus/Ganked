<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\Post;
    use Ganked\Library\ValueObjects\UserId;

    class CreateNewPostCommand
    {
        /**
         * @var GankedApiGateway
         */
        private $gankedApiGateway;

        /**
         * @param GankedApiGateway $gankedApiGateway
         */
        public function __construct(GankedApiGateway $gankedApiGateway)
        {
            $this->gankedApiGateway = $gankedApiGateway;
        }

        /**
         * @param Post   $post
         * @param UserId $userId
         *
         * @return mixed
         */
        public function execute(Post $post, UserId $userId)
        {
            return $this->gankedApiGateway->createNewPost($post, $userId)->getDecodedJsonResponse();
        }
    }
}
