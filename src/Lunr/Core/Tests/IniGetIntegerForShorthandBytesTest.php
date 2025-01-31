<?php

/**
 * This file contains the IniGetIntegerForShorthandBytesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Core\Tests;

/**
 * This class contains tests for the get_integer_for_shorthand_bytes() method.
 *
 * @covers Lunr\Core\Ini
 */
class IniGetIntegerForShorthandBytesTest extends IniTestCase
{

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setupMain();
    }

    /**
     * Test get_integer_for_shorthand_bytes().
     *
     * @param string $string  Shorthand byte string
     * @param int    $integer Integer bytes
     *
     * @dataProvider shorthandBytesProvider
     * @covers       Lunr\Core\Ini::get_integer_for_shorthand_bytes
     */
    public function testGetIntegerForShorthandBytes($string, $integer): void
    {
        $this->assertSame($integer, $this->class->get_integer_for_shorthand_bytes($string));
    }

}

?>
