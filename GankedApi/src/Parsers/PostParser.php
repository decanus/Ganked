<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Parsers
{
    class PostParser 
    {
        /**
         * @param string $post
         *
         * @return array
         */
        public function parse($post)
        {

            $post = trim($post);

            $postArray = [
                'text' => $post,
                'entities' => [
                    'hashtags' => $this->parseHashTags($post),
                    'mentions' => $this->parseMentions($post),
                    'urls' => $this->parseUrls($post)
                ]
            ];

            return $postArray;
        }

        /**
         * @param string $post
         *
         * @return array
         */
        private function parseHashTags($post)
        {
            preg_match_all('/(?<=\s)#([^\s]+)/', $post, $tags);

            $tags = $tags[0];

            if (empty($tags)) {
                return [];
            }

            foreach ($tags as $tag) {
                $hashTags[] = $this->createEntity($post, $tag, '#');
            }

            return $hashTags;
        }

        /**
         * @param $post
         *
         * @return array
         */
        private function parseMentions($post)
        {
            preg_match_all('/(?<=\s)@([^\s]+)/', $post, $tags);

            $tags = $tags[0];

            if (empty($tags)) {
                return [];
            }

            foreach ($tags as $tag) {
                $mentions[] = $this->createEntity($post, $tag, '@');
            }

            return $mentions;
        }


        /**
         * @param $post
         *
         * @return array
         */
        private function parseUrls($post)
        {
            preg_match_all('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $post, $urls);

            $urls = $urls[0];

            if (empty($urls)) {
                return [];
            }

            foreach ($urls as $url) {
                $links[] = $this->createEntity($post, $url, '');
            }

            return $links;
        }

        /**
         * @param string $post
         * @param string $text
         * @param string $prefix
         *
         * @return array
         */
        private function createEntity($post, $text, $prefix)
        {
            $position = strpos($post, $text);
            return ['text' => ltrim($text, $prefix), 'offset' => [$position, $position + strlen($text)]];
        }
    }
}
