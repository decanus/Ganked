<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers\Get\Account
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\FetchAccountWithEmailQuery;
    use Ganked\API\Queries\FetchAccountWithUsernameQuery;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\NotFound;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchAccountWithUsernameQuery
         */
        private $fetchAccountWithUsernameQuery;

        /**
         * @var FetchAccountWithEmailQuery
         */
        private $fetchAccountWithEmailQuery;

        /**
         * @param FetchAccountWithUsernameQuery $fetchAccountWithUsernameQuery
         * @param FetchAccountWithEmailQuery    $fetchAccountWithEmailQuery
         */
        public function __construct(
            FetchAccountWithUsernameQuery $fetchAccountWithUsernameQuery,
            FetchAccountWithEmailQuery $fetchAccountWithEmailQuery
        )
        {
            $this->fetchAccountWithUsernameQuery = $fetchAccountWithUsernameQuery;
            $this->fetchAccountWithEmailQuery = $fetchAccountWithEmailQuery;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            $paths = explode('/', ltrim($request->getUri()->getPath(), '/'));

            $model->setObjectType('accounts');

            if ($this->isEmail($paths[1])) {
                $account = $this->fetchAccountWithEmailQuery->execute(new Email($paths[1]));
            }

            if ($this->isUsername($paths[1])) {
                $account = $this->fetchAccountWithUsernameQuery->execute(new Username($paths[1]));
            }

            if ($account === null) {
                throw new ApiException('Account does not exist', 0, null, new NotFound);
            }

            $model->setData($account);

        }

        /**
         * @param string $account
         *
         * @return bool
         */
        private function isEmail($account)
        {
            try {
                new Email($account);
            } catch (\InvalidArgumentException $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $account
         *
         * @return bool
         */
        private function isUsername($account)
        {
            try {
                new Username($account);
            } catch (\InvalidArgumentException $e) {
                return false;
            }

            return true;
        }

    }
}
