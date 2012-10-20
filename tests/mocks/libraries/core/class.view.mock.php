<?php

/**
 * This file contains a Mock class for Lunr's View Class
 * used by the Unit tests.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Mocks
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Mocks\Libraries\Core;
use Lunr\Libraries\Core\View;

/**
 * View Mock class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Mocks
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MockView extends View
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(new MockWebController());
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
        echo "HTML Output";
    }
}

?>
