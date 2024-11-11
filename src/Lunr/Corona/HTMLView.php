<?php

/**
 * This file contains a html view class.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Core\Configuration;

/**
 * View class used by the Website
 */
abstract class HTMLView extends View
{

    /**
     * List of javascript files to include.
     * @var array
     */
    protected $javascript;

    /**
     * List of stylesheets to include.
     * @var array
     */
    protected $stylesheets;

    /**
     * Constructor.
     *
     * @param Request       $request       Shared instance of the Request class
     * @param Response      $response      Shared instance of the Response class
     * @param Configuration $configuration Shared instance of the Configuration class
     */
    public function __construct($request, $response, $configuration)
    {
        parent::__construct($request, $response, $configuration);

        $this->javascript  = [];
        $this->stylesheets = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();

        unset($this->javascript);
        unset($this->stylesheets);
    }

    /**
     * Generate css include statements.
     *
     * @param bool $sort Whether to sort the list of css files or not
     *
     * @return string $links Generated html code for including css stylesheets
     */
    protected function include_stylesheets($sort = FALSE)
    {
        $links = '';

        if ($sort === TRUE)
        {
            sort($this->stylesheets);
        }

        foreach ($this->stylesheets as $stylesheet)
        {
            if (!$this->is_external($stylesheet))
            {
                $stylesheet .= '?' . filemtime($this->request->application_path . str_replace($this->request->base_path, '', $stylesheet));
            }

            $links .= '<link rel="stylesheet" type="text/css" href="' . $stylesheet . '">' . "\n";
        }

        return $links;
    }

    /**
     * Generate javascript include statements.
     *
     * @param bool $sort Whether to sort the list of js files or not
     *
     * @return string $links Generated html code for including javascript
     */
    protected function include_javascript($sort = FALSE)
    {
        $links = '';

        if ($sort === TRUE)
        {
            sort($this->javascript);
        }

        foreach ($this->javascript as $js)
        {
            if (!$this->is_external($js))
            {
                $js .= '?' . filemtime($this->request->application_path . str_replace($this->request->base_path, '', $js));
            }

            $links .= '<script src="' . $js . '"></script>' . "\n";
        }

        return $links;
    }

    /**
     * Check of a URI is external or local
     *
     * @param string $uri A URI
     *
     * @return bool if the URI is external or not
     */
    private function is_external($uri)
    {
        return (strpos($uri, 'http://') === 0 || strpos($uri, 'https://') === 0 || strpos($uri, '//') === 0);
    }

    /**
     * Return an alternating (eg. odd/even) CSS class name.
     *
     * @param string $basename         CSS base class name (without
     *                                 ending underscore or suffix)
     * @param int    $alternation_hint Integer counter indicating the
     *                                 alternation state
     * @param string $suffix           An alternative suffix if you
     *                                 don't want odd/even
     *
     * @return string $return The constructed CSS class name
     */
    protected function css_alternate($basename, $alternation_hint, $suffix = '')
    {
        if ($suffix == '')
        {
            if ($alternation_hint % 2 == 0)
            {
                $basename .= '_even';
            }
            else
            {
                $basename .= '_odd';
            }
        }
        else
        {
            $basename .= '_' . $suffix;
        }

        return $basename;
    }

}

?>
