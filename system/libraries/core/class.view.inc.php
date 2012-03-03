<?php

/**
 * This file contains a view class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * View class used by the Website
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class View
{

    /**
     * Reference to the Request class
     * @var Request
     */
    protected $request;

    /**
     * Reference to the Response class
     * @var Response
     */
    protected $response;

    /**
     * Reference to the Configuration class
     * @var Configuration
     */
    protected $configuration;

    /**
     * Reference to the Localization provider
     * @var L10nProvider
     */
    protected $l10n;

    /**
     * Constructor.
     *
     * @param Request       &$request       Reference to the Request class
     * @param Response      &$response      Reference to the Response class
     * @param Configuration &$configuration Reference to the Configuration class
     * @param L10nProvider  &$l10nprovider  Reference to the L10nProvider class
     */
    public function __construct(&$request, &$response, &$configuration, &$l10nprovider)
    {
        $this->request =& $request;
        $this->response =& $response;
        $this->configuration =& $configuration;
        $this->l10n =& $l10nprovider;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->request = NULL;
        $this->response = NULL;
        $this->configuration = NULL;
        $this->l10n = NULL;
    }

    /**
     * Build the actual display and print it.
     *
     * @return void
     */
    abstract public function print_page();

    /**
     * Return base_url or attach given path to base_url.
     *
     * @param String $path Path that should be attached to base_url (optional)
     *
     * @return String $return base_url (+ the given path, if given)
     */
    protected function base_url($path = '')
    {
        return $this->request->base_url . $path;
    }

    /**
     * Return path to statics or attach given path to it.
     *
     * @param String $path Path that should be attached to the statics path
     *                     (optional)
     *
     * @return String $return path to statics (+ the given path, if given)
     */
    protected function statics($path = '')
    {
        $output  = '';
        $base    = '/' . trim($this->request->base_path, '/');
        $statics = '/' . trim($this->configuration['path']['statics'], '/');
        $path    = '/' . trim($path, '/');

        if ($base != '/')
        {
            $output .= $base;
        }

        if ($statics != '/')
        {
            $output .= $statics;
        }

        $output .= $path;
        return $output;
    }

    /**
     * Return an alternating (eg. odd/even) CSS class name.
     *
     * @param String  $basename         CSS base class name (without
     *                                  ending underscore or suffix)
     * @param Integer $alternation_hint Integer counter indicating the
     *                                  alternation state
     * @param String  $suffix           An alternative suffix if you
     *                                  don't want odd/even
     *
     * @return String $return The constructed CSS class name
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
