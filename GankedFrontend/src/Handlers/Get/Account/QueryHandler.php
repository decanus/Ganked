<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get\Account
{

    use Ganked\Frontend\Models\AccountPageModel;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Skeleton\Handlers\QueryHandlerInterface;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;
    use Ganked\Skeleton\Queries\FetchAccountQuery;

    class QueryHandler implements QueryHandlerInterface, LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var FetchAccountQuery
         */
        private $fetchAccountQuery;

        /**
         * @param FetchAccountQuery $fetchAccountQuery
         */
        public function __construct(FetchAccountQuery $fetchAccountQuery)
        {
            $this->fetchAccountQuery = $fetchAccountQuery;
        }

        /**
         * @param AbstractRequest    $request
         * @param AccountPageModel   $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model)
        {
            $data = [];

            try {
                /**
                 * @var $account RegisteredAccount
                 */
                $account = $model->getAccount();
                $data = $this->fetchAccountQuery->execute($account->getEmail())['data'];
            } catch (\Exception $e) {
                var_dump($e);exit;
                $this->logCriticalException($e);
            }

            $model->setAccountData($data);
        }
    }
}
