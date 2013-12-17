<?php

/**
 * This file contains a view class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * View class used by the Website
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class View
{

    /**
     * Shared instance of the Request class
     * @var RequestInterface
     */
    protected $request;

    /**
     * Shared instance of the Response class
     * @var Response
     */
    protected $response;

    /**
     * Shared instance of the Configuration class
     * @var Configuration
     */
    protected $configuration;

    /**
     * Constructor.
     *
     * @param RequestInterface $request       Shared instance of the Request class
     * @param Response         $response      Shared instance of the Response class
     * @param Configuration    $configuration Shared instance of to the Configuration class
     */
    public function __construct($request, $response, $configuration)
    {
        $this->request       = $request;
        $this->response      = $response;
        $this->configuration = $configuration;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->response);
        unset($this->configuration);
    }

    /**
     * Build the actual display and print it.
     *
     * @return void
     */
    abstract public function print_page();

    /**
     * Build display for Fatal Error output.
     *
     * @return void
     */
    abstract public function print_fatal_error();

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

}

?>
