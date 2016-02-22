<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite
{

    use Ganked\API\Handlers\AbstractResponseHandler;
    use Ganked\API\Models\ApiModel;
    use Ganked\API\Models\MongoCursorModel;

    class ResponseHandler extends AbstractResponseHandler
    {

        /**
         * @param ApiModel $model
         *
         * @return array
         */
        protected function handleResponse(ApiModel $model)
        {
            $cursor = $model->getData();
            $return = [];

            foreach ($cursor as $item) {
                $data = json_decode($item, true);

                if ($data === null) {
                    continue;
                }

                $return[] = $data;
            }

            return $return;
        }
    }
}
