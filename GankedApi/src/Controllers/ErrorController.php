<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Controllers
{
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\StatusCodes\BadRequest;

    class ErrorController extends AbstractPageController
    {
        protected function run()
        {
            $this->getResponse()->setStatusCode(new BadRequest);
        }

        /**
         * @return string
         * @throws \Exception
         */
        protected function getRendererResultBody()
        {
            return json_encode([
                'error' => [
                    'message' => 'Unsupported ' . $this->getRequest()->getServerParameter('REQUEST_METHOD') . ' request method',
                    'code' => '400'
                ]
            ]);
        }
    }
}
