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
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Mocks\Libraries\Core;
use Lunr\Libraries\Core\View;

/**
 * View Mock class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Mocks
 * @author     M2Mobi <info@m2mobi.com>
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
