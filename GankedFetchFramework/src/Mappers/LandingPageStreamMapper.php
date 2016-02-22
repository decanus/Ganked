<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Mappers
{
    class LandingPageStreamMapper
    {
        /**
         * @param array $response
         *
         * @return array
         */
        public function map(array $response)
        {
            if (empty($response['streams'])) {
                return ['streams' => null];
            }

            $streams = [];

            foreach($response['streams'] as $stream) {
                if (empty($stream)) {
                    continue;
                }

                $return = [
                    'name' => $stream['channel']['name'],
                    'display_name' => $stream['channel']['display_name'],
                    'preview' => $stream['preview']['medium'],
                    'src' => 'http://www.twitch.tv/' . $stream['channel']['name'] . '/embed'
                ];

                if (isset($stream['channel']['video_banner'])) {
                    $return['banner'] = $stream['channel']['video_banner'];
                } else {
                    $return['banner'] = $stream['preview']['large'];
                }

                $streams[] = $return;
            }

            return ['streams' => $streams];
        }
    }
}
