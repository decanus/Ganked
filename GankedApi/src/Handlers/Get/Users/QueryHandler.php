<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Users
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\FetchUserByIdQuery;
    use Ganked\API\Queries\FetchUserBySteamIdQuery;
    use Ganked\API\Queries\GetUserFromDatabaseQuery;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\InternalServerError;
    use Ganked\Skeleton\Http\StatusCodes\NotFound;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var GetUserFromDatabaseQuery
         */
        private $getUserFromDatabaseQuery;

        /**
         * @var FetchUserByIdQuery
         */
        private $fetchUserByIdQuery;

        /**
         * @var FetchUserBySteamIdQuery
         */
        private $fetchUserBySteamIdQuery;

        /**
         * @param GetUserFromDatabaseQuery $getUserFromDatabaseQuery
         * @param FetchUserByIdQuery       $fetchUserByIdQuery
         * @param FetchUserBySteamIdQuery  $fetchUserBySteamIdQuery
         */
        public function __construct(
            GetUserFromDatabaseQuery $getUserFromDatabaseQuery,
            FetchUserByIdQuery $fetchUserByIdQuery,
            FetchUserBySteamIdQuery $fetchUserBySteamIdQuery
        )
        {
            $this->getUserFromDatabaseQuery = $getUserFromDatabaseQuery;
            $this->fetchUserByIdQuery = $fetchUserByIdQuery;
            $this->fetchUserBySteamIdQuery = $fetchUserBySteamIdQuery;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @return array
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $path = $request->getUri()->getExplodedPath()[1];

            $fields = [];
            if ($request->hasParameter('fields')) {
                $fields = explode(',', $request->getParameter('fields'));
            }

            $user = null;

            try {
                if ($this->isSteamId($path)) {
                    $user = $this->fetchUserBySteamIdQuery->execute(new SteamId($path), $fields);
                }

                if ($this->isUsername($path) && $user === null) {
                    $user = $this->getUserFromDatabaseQuery->execute(new Username($path), $fields);
                }

                if ($this->isMongoId($path) && $user === null) {
                    $user = $this->fetchUserByIdQuery->execute(new \MongoId($path), $fields);
                }
            } catch (\Exception $e) {
                throw new ApiException('Unknown Error', 0, $e, new InternalServerError);
            }

            if ($user === null) {
                throw new ApiException('User ' . $path . ' does not exist', 0, null, new NotFound);
            }

            $model->setObjectType('users');
            $model->setData($user);
        }


        /**
         * @param string $username
         *
         * @return bool
         */
        private function isUsername($username)
        {
            try {
                new Username($username);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $steamId
         *
         * @return bool
         */
        private function isSteamId($steamId)
        {
            try {
                new SteamId($steamId);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        private function isMongoId($id)
        {
            try {
                new \MongoId($id);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }
    }
}
