<?php

/**
 * This file contains the MsgpackViewBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the MsgpackView class.
 *
 * @covers     Lunr\Corona\MsgpackView
 */
class MsgpackViewBaseTest extends MsgpackViewTestCase
{

    /**
     * Test that the Request class is passed correctly.
     */
    public function testRequestIsPassedCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class is passed correctly.
     */
    public function testResponseIsPassedCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the Configuration class is passed correctly.
     */
    public function testConfigurationIsPassedCorrectly(): void
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that prepare_data() does not modify the data.
     *
     * @covers Lunr\Corona\MsgpackView::prepare_data
     */
    public function testPrepareDataReturnsUnmodifiedData(): void
    {
        $data = [ 'key' => 'value', 'key2' => NULL ];

        $method = $this->getReflectionMethod('prepare_data');

        $this->assertSame($data, $method->invokeArgs($this->class, [ $data ]));
    }

}

?>
