<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Models
{

    use Ganked\Library\ValueObjects\MetaTags;
    use Ganked\Skeleton\Queries\FetchAccountFromSessionQuery;

    abstract class AbstractPageModel extends AbstractModel
    {
        /**
         * @var int
         */
        private $responseCode = 200;

        /**
         * @var MetaTags
         */
        private $metaTags;

        /**
         * @var FetchAccountFromSessionQuery
         */
        private $fetchAccountFromSessionQuery;

        /**
         * @param int $responseCode
         */
        public function setResponseCode($responseCode)
        {
            $this->responseCode = $responseCode;
        }

        /**
         * @return int
         */
        public function getResponseCode()
        {
            return $this->responseCode;
        }

        /**
         * @param MetaTags $metaTags
         */
        public function setMetaTags(MetaTags $metaTags)
        {
            $this->metaTags = $metaTags;
        }

        /**
         * @return MetaTags
         */
        public function getMetaTags()
        {
            return $this->metaTags;
        }

        /**
         * @param FetchAccountFromSessionQuery $fetchAccountFromSessionQuery
         */
        public function setFetchAccountFromSessionQuery(FetchAccountFromSessionQuery $fetchAccountFromSessionQuery)
        {
            $this->fetchAccountFromSessionQuery = $fetchAccountFromSessionQuery;
        }

        /**
         * @return \Ganked\Library\DataObjects\Accounts\AccountInterface
         */
        public function getAccount()
        {
            return $this->fetchAccountFromSessionQuery->execute();
        }
    }
}
