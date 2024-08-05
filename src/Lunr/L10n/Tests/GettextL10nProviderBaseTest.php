<?php

/**
 * This file contains the GettextL10nProviderBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

/**
 * This class contains the tests for the constructor and init function.
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
    public function testInit(): void
    {
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, [ self::LANGUAGE ]);

        $this->assertEquals(self::LANGUAGE, setlocale(LC_MESSAGES, 0));
        $this->assertEquals(self::DOMAIN, textdomain(NULL));
    }

}

?>
