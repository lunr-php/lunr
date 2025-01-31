<?php

/**
 * This file contains the ModelBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Model class.
 *
 * @covers Lunr\Corona\Model
 */
class ModelBaseTest extends ModelTestCase
{

    /**
     * Test that the Pool class is set correctly.
     */
    public function testPoolSetCorrectly(): void
    {
        $this->assertPropertySame('cache', $this->cache);
    }

}

?>
