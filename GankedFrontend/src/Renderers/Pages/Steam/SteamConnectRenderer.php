<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\SteamConnectModel;

    class SteamConnectRenderer extends AbstractPageRenderer
    {

        protected function doRender()
        {
            $this->setTitle('Steam Connect');

            $template = $this->getTemplate();

            $box = $template->createElement('div');
            $box->setAttribute('class', 'generic-box -fit -center -small');
            $box->appendChild($template->createElement('h1', 'An error occurred'));

            /**
             * @var $model SteamConnectModel
             */
            $model = $this->getModel();

            if (!$model->hasClaimedId()) {
                $box->appendChild($template->createElement('p', 'There was an error connecting your steam account, please try again later.'));
            }

            if ($model->isAlreadyInUse()) {
                $box->appendChild($template->createElement('p', 'This Steam account has already been connected to a user.'));
            }

            $template->getElementById('main')->appendChild($box);
        }
    }
}
