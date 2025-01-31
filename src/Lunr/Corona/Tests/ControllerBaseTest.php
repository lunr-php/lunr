<?php

/**
 * This file contains the ControllerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Controller class.
 *
 * @covers     Lunr\Corona\Controller
 */
class ControllerBaseTest extends ControllerTestCase
{

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly(): void
    {
        $this->assertSame($this->response, $this->getReflectionPropertyValue('response'));
    }

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly(): void
    {
        $this->assertSame($this->request, $this->getReflectionPropertyValue('request'));
    }

}

?>
