<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers
{

    use Ganked\API\Exceptions\ApiException;
    use Ganked\API\Models\ApiModel;

    abstract class AbstractResponseHandler
    {
        /**
         * @param ApiModel $model
         *
         * @return array
         */
        public function execute(ApiModel $model)
        {
            if ($model->hasException()) {
                return $this->handleError($model->getException());
            }

            return ['data' =>  $this->handleResponse($model)];
        }

        /**
         * @param ApiException $e
         *
         * @return array
         */
        private function handleError(ApiException $e)
        {
            return [
                'errors' => [
                    'message' => $e->getMessage(),
                    'code' => (string) $e->getStatusCode()
                ]
            ];
        }

        /**
         * @param array  $object
         * @param string $type
         *
         * @return array
         */
        protected function handleObject(array $object, $type = '')
        {
            if ($type !== '') {
                $data['type'] = $type;
            }

            if (isset($object['_id'])) {
                $data['id'] = (string) $object['_id'];
                unset($object['_id']);
            }

            $data['attributes'] = $object;

            return $data;
        }

        /**
         * @param ApiModel $model
         *
         * @return array
         */
        abstract protected function handleResponse(ApiModel $model);

    }
}
