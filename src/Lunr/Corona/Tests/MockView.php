<?php

/**
 * This file contains a Mock class for Lunr's View Class
 * used by the Unit tests.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Mocks
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\View;

/**
 * View Mock class
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Mocks
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MockView extends View
{

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
        parent::__construct($request, $response, $configuration, $l10nprovider);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Build the actual display and print it.
     *
     * @return void
     */
    public function print_page()
    {
        echo 'HTML Output';
    }

}

?>
