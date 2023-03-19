<?php

/**
 * This file contains the EnvironmentTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class tests for a proper test environment.
 *
 * @covers Lunr\EnvironmentTest
 */
class EnvironmentTest extends TestCase
{

    /**
     * Test whether we have language files available.
     */
    public function testL10nFiles(): void
    {
        $file = TEST_STATICS . '/l10n/de_DE/LC_MESSAGES/Lunr.mo';
        if (!file_exists($file))
        {
            $this->markTestSkipped('.mo file required, please run ant l10n to generate it');
            return;
        }

        $this->assertTrue(file_exists($file));
    }

}

?>
