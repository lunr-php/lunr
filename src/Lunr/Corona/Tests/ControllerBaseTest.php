<?php

/**
 * This file contains the ControllerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Controller class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\Controller
 */
class ControllerBaseTest extends ControllerTest
{

    /**
     * Test that there are no error enums set by default.
     */
    public function testErrorEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('error'));
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly()
    {
        $this->assertSame($this->response, $this->get_reflection_property_value('response'));
    }

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $this->assertSame($this->request, $this->get_reflection_property_value('request'));
    }

}

?>
