<?php

/**
 * This file contains a view class.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n;

use Lunr\Corona\HTMLView;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Core\Configuration;

/**
 * View class used by the Website
 */
abstract class L10nHTMLView extends HTMLView
{

    /**
     * Shared instance of the Localization provider
     * @var L10nProvider
     */
    protected $l10n;

    /**
     * Constructor.
     *
     * @param Request       $request       Shared instance of the Request class
     * @param Response      $response      Shared instance of the Response class
     * @param Configuration $configuration Shared instance of the Configuration class
     * @param L10nProvider  $l10nprovider  Shared instance of the L10nProvider class
     */
    public function __construct($request, $response, $configuration, $l10nprovider)
    {
        parent::__construct($request, $response, $configuration);

        $this->l10n = $l10nprovider;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->l10n);

        parent::__destruct();
    }

}

?>
