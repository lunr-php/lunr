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
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains basic test methods for the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\NetworkErrorTrait
 */
class NetworkErrorTraitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Object instance using NetworkErrorTrait.
     * @var NetworkErrorTrait
     */
    protected $network_error_trait;

    /**
     * Reflection instance of the Object using the NetworkErrorTrait.
     * @var ReflectionClass
     */
    protected $network_error_trait_reflection;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->network_error_trait = $this->getObjectForTrait('Lunr\Network\NetworkErrorTrait');

        $this->network_error_trait_reflection = new ReflectionClass($this->network_error_trait);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->network_error_trait);
        unset($this->network_error_trait_reflection);
    }

    /**
     * Test that we can get the stored error message.
     *
     * @covers Lunr\Network\NetworkErrorTrait::get_network_error_message
     */
    public function testReturnErrorMessage()
    {
        $property = $this->network_error_trait_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);
        $property->setValue($this->network_error_trait, 'Message');

        $this->assertEquals('Message', $this->network_error_trait->get_network_error_message());
    }

    /**
     * Test that we can get the stored error number.
     *
     * @covers Lunr\Network\NetworkErrorTrait::get_network_error_number
     */
    public function testReturnErrorNumber()
    {
        $property = $this->network_error_trait_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);
        $property->setValue($this->network_error_trait, 100);

        $this->assertEquals(100, $this->network_error_trait->get_network_error_number());
    }

}

?>
