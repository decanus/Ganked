<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Post\Authenticate
{

    use Ganked\API\Handlers\QueryHandlerInterface;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Queries\FetchAccountWithEmailQuery;
    use Ganked\API\Queries\FetchAccountWithUsernameQuery;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class QueryHandler implements QueryHandlerInterface
    {
        /**
         * @var FetchAccountWithEmailQuery
         */
        private $fetchAccountWithEmailQuery;

        /**
         * @var FetchAccountWithUsernameQuery
         */
        private $fetchAccountWithUsernameQuery;

        /**
         * @param FetchAccountWithEmailQuery    $fetchAccountWithEmailQuery
         * @param FetchAccountWithUsernameQuery $fetchAccountWithUsernameQuery
         */
        public function __construct(
            FetchAccountWithEmailQuery $fetchAccountWithEmailQuery,
            FetchAccountWithUsernameQuery $fetchAccountWithUsernameQuery
        )
        {
            $this->fetchAccountWithEmailQuery = $fetchAccountWithEmailQuery;
            $this->fetchAccountWithUsernameQuery = $fetchAccountWithUsernameQuery;
        }

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         *
         * @throws \Exception
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
            try {

                $user = $request->getParameter('user');

                if ($this->isEmail($user)) {
                    $data = $this->fetchAccountWithEmailQuery->execute(new Email($user));
                } else {
                    $data = $this->fetchAccountWithUsernameQuery->execute(new Username($user));
                }

                $hash = new Hash($request->getParameter('password'), $data['salt']);

                if ((string) $hash !== $data['password']) {
                    throw new \Exception('Invalid password');
                }

                $model->setData(['user' => (string) $data['_id']]);
            } catch (\Exception $e) {
                $model->setData(['status' => false]);
            }
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
    }
}
