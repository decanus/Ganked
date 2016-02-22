<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Renderers
{

    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;

    class RssFeedsRenderer implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var \DateTime
         */
        private $dateTime;

        /**
         * @var array
         */
        private $newsItems = [];

        /**
         * @param DataPoolReader $dataPoolReader
         * @param \DateTime      $dateTime
         */
        public function __construct(DataPoolReader $dataPoolReader, \DateTime $dateTime)
        {
            $this->dataPoolReader = $dataPoolReader;
            $this->dateTime = $dateTime;
        }

        /**
         * @param \DOMElement $operation
         */
        public function render(\DOMElement $operation)
        {
            $limit = 0;
            if ($operation->hasAttribute('limit')) {
                $limit = (int) $operation->getAttribute('limit');
            }

            $filter = '';
            if ($operation->hasAttribute('game')) {
                $filter = $operation->getAttribute('game');
            }

            try {
                if ($filter === '') {
                    $feeds = $this->dataPoolReader->getRssFeeds();
                    foreach ($feeds as $game => $feed) {
                        if ($game === 'csgo' || $game === 'dota' || $game === 'lol') {
                            $this->handleSteamGame(new DomHelper($feed));
                        }

                        if ($game === 'wow') {
                            $this->handleWorldOfWarcraft(new DomHelper($feed));
                        }
                    }
                } else {
                    $feed = $this->dataPoolReader->getRssFeedsForGame($filter);
                    if ($filter === 'csgo' || $filter === 'dota' || $filter === 'lol') {
                        $this->handleSteamGame(new DomHelper($feed));
                    }


                    if ($filter === 'wow') {
                        $this->handleWorldOfWarcraft(new DomHelper($feed));
                    }
                }

                usort($this->newsItems, function ($a, $b) {
                   return $b['published'] - $a['published'];
                });

                $dom = $operation->ownerDocument;


                foreach ($this->newsItems as $index => $item) {
                    if ($limit !== 0 && $limit === $index) {
                        break;
                    }

                    try {
                        $newsItem = $dom->createElement('div');
                        $newsItem->setAttribute('class', 'item -flex');

                        $newsElement = $dom->createElement('article');
                        $newsElement->setAttribute('class', 'generic-box -no-margin');
                        $newsElement->appendChild($dom->createElement('h3', $item['title']));
                        $newsItem->appendChild($newsElement);

                        $this->dateTime->setTimestamp($item['published']);
                        $time = $dom->createElement('time', 'on ' . $this->dateTime->format('M d'));
                        $time->setAttribute('class', '_dim');
                        $time->setAttribute('is', 'relative-time');
                        $time->setAttribute('datetime', $this->dateTime->format(\DateTime::ISO8601));
                        $newsElement->appendChild($time);

                        $text = $dom->createElement('p');
                        $text->appendChild($dom->createTextNode($item['description'] . '... '));
                        $newsElement->appendChild($text);

                        $link = $dom->createElement('a', 'Continue Reading');
                        $link->setAttribute('href', $item['link']);
                        $link->setAttribute('rel', 'nofollow');
                        $newsElement->appendChild($link);

                        $operation->parentNode->appendChild($newsItem);
                    } catch (\Exception $e) {
                        continue;
                    }
                }

            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }
        }

        /**
         * @param DomHelper $feed
         */
        private function handleSteamGame(DomHelper $feed)
        {
            $items = $feed->query('/rss/channel/item');

            /**
             * @var $item \DomElement
             */
            foreach ($items as $item) {
                try {
                    $newsItem['title'] = $item->getElementsByTagName('title')->item(0)->nodeValue;
                    $newsItem['link'] = $item->getElementsByTagName('link')->item(0)->nodeValue;
                    $newsItem['published'] = $this->dateTime->createFromFormat('l, d M Y H:i:s e', $item->getElementsByTagName('pubDate')->item(0)->nodeValue)->getTimestamp();
                    $description = html_entity_decode($item->getElementsByTagName('description')->item(0)->nodeValue);
                    $description = strip_tags($description);
                    $description = str_replace('[…]', '', $description);
                    $linkPosition = strpos($description, '<a') - 2;
                    $description = trim(substr_replace($description, '', $linkPosition, strlen($description)));
                    $newsItem['description'] = $description;
                    $this->newsItems[] = $newsItem;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        /**
         * @param DomHelper $feed
         */
        private function handleWorldOfWarcraft(DomHelper $feed)
        {
            $items = $feed->getElementsByTagName('entry');

            /**
             * @var $item \DomElement
             */
            foreach ($items as $item) {
                try {
                    $newsItem['title'] = $item->getElementsByTagName('title')->item(0)->nodeValue;
                    $newsItem['link'] = $item->getElementsByTagName('link')->item(0)->getAttribute('href');
                    $newsItem['published'] = strtotime($item->getElementsByTagName('published')->item(0)->nodeValue);
                    $description = $item->getElementsByTagName('summary')->item(0)->getElementsByTagName('div')->item(0)->nodeValue;
                    $newsItem['description'] = $description;
                    $this->newsItems[] = $newsItem;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
    }
}
