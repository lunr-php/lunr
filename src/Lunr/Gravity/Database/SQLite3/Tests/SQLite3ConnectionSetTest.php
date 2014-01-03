<?php

/**
 * This file contains the SQLite3ConnectionSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;

/**
 * This class contains test for the setters of the SQLite3Connection class.
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionSetTest extends SQLite3ConnectionTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->emptySetUp();
    }

    /**
     * Test that set_configuration sets database correctly.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::set_configuration
     */
    public function testSetConfigurationSetsDatabaseCorrectly()
    {

        $this->configuration->expects($this->any())
                           ->method('offsetGet')
                           ->with('db')
                           ->will($this->returnValue(array('file' => NULL)));

        $this->set_reflection_property_value('db', '');

        $method = $this->get_accessible_reflection_method('set_configuration');

        $method->invoke($this->class);

        $this->assertEquals(':memory:', $this->get_reflection_property_value('db'));
    }

    /**
     * Test that set_configuration doesn't set the database.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::set_configuration
     */
    public function testSetConfigurationDoesNotSetDatabase()
    {

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->with('db')
                            ->will($this->returnValue(array('file' => NULL)));

        $this->set_reflection_property_value('db', '');

        $method = $this->get_accessible_reflection_method('set_configuration');

        $method->invoke($this->class);

        $this->assertEquals(':memory:', $this->get_reflection_property_value('db'));
    }

}

?>
