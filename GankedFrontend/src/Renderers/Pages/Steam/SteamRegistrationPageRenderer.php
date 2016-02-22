<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\SteamRegistrationPageModel;

    class SteamRegistrationPageRenderer extends AbstractPageRenderer
    {

        protected function doRender()
        {
            $template = $this->getDomFromTemplate('templates://content/steam/register.xhtml');
            $this->setTitle('Steam Registration');

            /**
             * @var $model SteamRegistrationPageModel
             */
            $model = $this->getModel();

            if ($model->hasUsername()) {
                $template->query('/div/form/fieldset/div/label/input[@name="username"]')->item(0)->setAttribute('value', (string) $model->getUsername());
            }

            if ($model->hasCustomId()) {
                $template->query('/div/form/fieldset/div/label/input[@name="customId"]')->item(0)->setAttribute('value', (string) $model->getCustomId());
            }

            $this->getSnippetTransformation()->appendToMain($template);
        }
    }
}
