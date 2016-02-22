<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
namespace Ganked\Backend\Builders
{
    use Ganked\Library\Generators\ImageUriGenerator;
    use Ganked\Library\Helpers\DomHelper;

    class CounterStrikeAchievementsTemplateBuilder
    {
        /**
         * @var ImageUriGenerator
         */
        private $imageUriGenerator;

        /**
         * @param ImageUriGenerator $imageUriGenerator
         */
        public function __construct(ImageUriGenerator $imageUriGenerator)
        {
            $this->imageUriGenerator = $imageUriGenerator;
        }

        /**
         * @param array $achievements
         * @return DomHelper
         */
        public function build(array $achievements)
        {
            $template = new DomHelper('<div class="generic-box -normal-padding"/>');

            $header = $template->firstChild->appendChild($template->createElement('header'));
            $header->setAttribute('class', 'title-action');

            $title = $header->appendChild($template->createElement('h3', 'Achievements'));
            $title->setAttribute('class', 'title');

            $showMore = $header->appendChild($template->createElement('a', 'Show More'));
            $showMore->setAttribute('is', 'additional-content-toggle-link');
            $showMore->setAttribute('class', 'action');
            $showMore->setAttribute('target-name', 'achievements');
            $showMore->setAttribute('show-more', 'Show More');
            $showMore->setAttribute('show-less', 'Show Less');

            $topGrid = $template->firstChild->appendChild($template->createElement('ul'));
            $topGrid->setAttribute('class', 'grid-wrapper -center -gap');

            $additionalContent = $template->firstChild->appendChild($template->createElement('additional-content'));
            $additionalContent->setAttribute('name', 'achievements');

            $bottomGrid = $additionalContent->appendChild($template->createElement('ul'));
            $bottomGrid->setAttribute('class', 'grid-wrapper -center -gap -flow-element');

            $grid = $topGrid;

            foreach($achievements as $index => $achievement) {
                $achievementItem = $grid->appendChild($template->createElement('li'));
                $achievementItem->setAttribute('class', 'item -center');
                $achievementItem->setAttribute('data-achievement', $achievement['name']);

                $image = $achievementItem->appendChild($template->createElement('img'));
                $image->setAttribute('src', $this->imageUriGenerator->createBlackAndWhiteCounterStrikeAchievementIconUri($achievement['name']));
                $image->setAttribute('alt', $achievement['displayName']);
                $image->setAttribute('class', '_dim');
                $image->setAttribute('data-info-box', 'info-box');

                $infoBox = $achievementItem->appendChild($template->createElement('info-box'));
                $infoBox->setAttribute('hidden', '');

                $infoBoxHeader = $infoBox->appendChild($template->createElement('div'));
                $infoBoxHeader->setAttribute('class', 'grid-wrapper -space-between -gap');

                $titleWrap = $infoBoxHeader->appendChild($template->createElement('div'));
                $titleWrap->setAttribute('class', 'item -center');

                $title = $titleWrap->appendChild($template->createElement('h3'));
                $title->nodeValue = $achievement['displayName'];
                $title->setAttribute('class', '_no-margin');

                $iconWrap = $infoBoxHeader->appendChild($template->createElement('div'));
                $iconWrap->setAttribute('class', 'item -center');

                $icon = $iconWrap->appendChild($template->createElement('span'));
                $icon->setAttribute('class', 'octicon octicon-x _red');

                $description = $infoBox->appendChild($template->createElement('p'));
                $description->nodeValue = $achievement['description'];
                $description->setAttribute('class', '_no-margin');


                if ($index === 9) {
                    $grid = $bottomGrid;
                }
            }

            return $template;
        }
    }
}