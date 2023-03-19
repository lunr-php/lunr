<?php

/**
 * This file contains the DatabaseQueryEscaperBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseQueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseQueryEscaper class.
 *
 * @covers Lunr\Gravity\Database\DatabaseQueryEscaper
 */
class DatabaseQueryEscaperBaseTest extends DatabaseQueryEscaperTest
{

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testDatabaseConnectionIsPassed(): void
    {
        $this->assertSame($this->db, $this->get_reflection_property_value('db'));
    }

}

?>
