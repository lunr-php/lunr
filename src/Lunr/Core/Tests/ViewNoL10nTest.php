<?php

/**
 * This file contains the ViewNoL10nTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\View;

/**
 * Base tests for the view class when there is no L10nProvider.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\View
 */
class ViewNoL10nTest extends ViewTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->setUpNoL10n();
    }

    /**
     * Test that the L10nProvider is NULL if not specified.
     */
    public function testL10nProviderIsNull()
    {
        $property = $this->view_reflection->getProperty('l10n');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->view));
    }

}

?>
