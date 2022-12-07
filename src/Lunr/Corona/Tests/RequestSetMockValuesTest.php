<?php

/**
 * This file contains the RequestSetMockValuesTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestSetMockValuesTest extends RequestTest
{

    /**
     * Test set_mock_values() sets values correctly.
     *
     * @covers Lunr\Corona\Request::set_mock_values
     */
    public function testSetMockValues(): void
    {
        $mock = [ 'controller' => 'newcontroller' ];

        $this->class->set_mock_values($mock);

        $this->assertEquals($mock, $this->get_reflection_property_value('mock'));
    }

}

?>
