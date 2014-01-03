<?php

/**
 * This file contains the NetworkErrorTraitTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains basic test methods for the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\NetworkErrorTrait
 */
class NetworkErrorTraitTest extends LunrBaseTest
{

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->class = $this->getObjectForTrait('Lunr\Network\NetworkErrorTrait');

        $this->reflection = new ReflectionClass($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Test that we can get the stored error message.
     *
     * @covers Lunr\Network\NetworkErrorTrait::get_network_error_message
     */
    public function testReturnErrorMessage()
    {
        $this->set_reflection_property_value('error_message', 'Message');

        $this->assertEquals('Message', $this->class->get_network_error_message());
    }

    /**
     * Test that we can get the stored error number.
     *
     * @covers Lunr\Network\NetworkErrorTrait::get_network_error_number
     */
    public function testReturnErrorNumber()
    {
        $this->set_reflection_property_value('error_number', 100);

        $this->assertEquals(100, $this->class->get_network_error_number());
    }

}

?>
