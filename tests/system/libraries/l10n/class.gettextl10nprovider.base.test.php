<?php

/**
 * This file contains the GettextL10nProviderBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\L10n;

/**
 * This class contains the tests for the contructor and init function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\GettextL10nProvider
 */
class GettextL10nProviderBaseTest extends GettextL10nProviderTest
{

    /**
     * Test that init() works correctly.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::init
     */
    public function testInit()
    {
        $method = $this->provider_reflection->getMethod('init');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->provider, array(self::LANGUAGE));

        $this->assertEquals(self::LANGUAGE, setlocale(LC_MESSAGES, 0));
        $this->assertEquals($this->configuration['l10n']['domain'], textdomain(NULL));
    }

}

?>
