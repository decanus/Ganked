<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Service
{

    use Ganked\Library\ValueObjects\Uri;

    class GetServiceHandler extends AbstractServiceHandler
    {
        /**
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        protected function doExecute()
        {
            $request = $this->getRequest();

            $data = [
                'method' => $request->getMethod(),
                'token' => $request->getToken(),
                'arguments' => json_encode($request->getData())
            ];

            return $this->getCurl()->get(
                new Uri($this->getServiceUri() . $request->getPath()),
                $data,
                [CURLINFO_HEADER_OUT => true]
            )->execute();
        }
    }
}
