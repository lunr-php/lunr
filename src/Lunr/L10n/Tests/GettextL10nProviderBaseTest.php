<?php

/**
 * This file contains the GettextL10nProviderBaseTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\L10n
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\GettextL10nProvider;

/**
 * This class contains the tests for the contructor and init function.
 *
 * @covers Lunr\L10n\GettextL10nProvider
 */
class GettextL10nProviderBaseTest extends GettextL10nProviderTest
{

    /**
     * Test that init() works correctly.
     *
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::init
     */
    public function testInit()
    {
        $current = textdomain(NULL);
        $locale  = setlocale(LC_MESSAGES, 0);

        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, [self::LANGUAGE]);

        $this->assertEquals(self::LANGUAGE, setlocale(LC_MESSAGES, 0));
        $this->assertEquals(self::DOMAIN, textdomain(NULL));

        textdomain($current);
        setlocale(LC_MESSAGES, $locale);
    }

}

?>
