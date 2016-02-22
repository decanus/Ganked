<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

// @codeCoverageIgnoreStart
namespace Ganked\Library\Backends
{

    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;

    class MongoDatabaseBackend implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var \MongoClient
         */
        private $mongoClient;

        /**
         * @var \MongoClient
         */
        private $mongoDatabase = null;

        /**
         * @var string
         */
        private $mongoDatabaseName;

        /**
         * @var bool
         */
        private $isConnected = false;

        /**
         * @param \MongoClient $mongoClient
         * @param string       $mongoDatabaseName
         */
        public function __construct(\MongoClient $mongoClient, $mongoDatabaseName)
        {
            $this->mongoClient = $mongoClient;
            $this->mongoDatabaseName = $mongoDatabaseName;
        }

        public function connect()
        {
            if ($this->isConnected) {
                return;
            }

            try {
                $this->mongoClient->connect();
            } catch (\Exception $e) {
                $this->logEmergencyException($e);
            }
        }

        /**
         * @param $collectionName
         * @param array $fieldSearchTerm
         * @param array $returnValue
         * @return \MongoCursor
         */
        public function findAll($collectionName, array $fieldSearchTerm, array $returnValue = [])
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->find($fieldSearchTerm, $returnValue);
        }

        /**
         * @param string $collectionName
         * @param array $fieldSearchTerm
         * @param array $returnValue
         * @return array|null
         */
        public function findOneInCollection($collectionName, array $fieldSearchTerm, array $returnValue = [])
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->findOne($fieldSearchTerm, $returnValue);
        }

        /**
         * @param array $value
         * @param string $collectionName
         * @return array|bool
         */
        public function insertArrayInCollection(array $value, $collectionName)
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->save($value);
        }

        /**
         * @param array  $data
         * @param string $collectionName
         *
         * @return array|bool
         */
        public function batchInsertIntoCollection(array $data, $collectionName)
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->batchInsert($data);
        }

        /**
         * @param string $query
         * @return array
         */
        public function executeQuery($query)
        {
            return $this->getSelectedDatabase()->execute($query);
        }

        /**
         * @param string $collectionName
         * @param array $query
         * @param array $options
         * @return array
         */
        public function aggregateCursor($collectionName, array $query, array $options = [])
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->aggregateCursor($query, $options);
        }

        /**
         * @param string $collectionName
         * @param array $searchTerm
         * @param array $newData
         * @return bool
         */
        public function updateDocument($collectionName, array $searchTerm, array $newData)
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->update($searchTerm, $newData);
        }

        /**
         * @param string $collectionName
         * @param array  $searchTerm
         *
         * @return array|bool
         */
        public function deleteDocument($collectionName, array $searchTerm)
        {
            return $this->getSelectedDatabase()->selectCollection($collectionName)->remove($searchTerm);
        }

        /**
         * @return \MongoDB
         */
        private function getSelectedDatabase()
        {
            $this->connect();
            if ($this->mongoDatabase === null) {
                return $this->mongoDatabase = $this->mongoClient->selectDB($this->mongoDatabaseName);
            }

            return $this->mongoDatabase;
        }

        /**
         * @param array $data
         * @param $collection
         * @return array|bool
         */
        public function removeDocument(array $data, $collection)
        {
            return $this->getSelectedDatabase()->selectCollection($collection)->remove($data);
        }

        public function closeConnection()
        {
            $this->mongoClient->close();
        }
    }
}
// @codeCoverageIgnoreEnd
