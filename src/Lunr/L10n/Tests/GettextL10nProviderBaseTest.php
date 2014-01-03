<?php

/**
 * This file contains the GettextL10nProviderBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\GettextL10nProvider;

/**
 * This class contains the tests for the contructor and init function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\GettextL10nProvider
 */
class GettextL10nProviderBaseTest extends GettextL10nProviderTest
{

    /**
     * Test that init() works correctly.
     *
     * @runInSeparateProcess
     *
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::init
     */
    public function testInit()
    {
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, array(self::LANGUAGE));

        $this->assertEquals(self::LANGUAGE, setlocale(LC_MESSAGES, 0));
        $this->assertEquals(self::DOMAIN, textdomain(NULL));
    }

}

?>
