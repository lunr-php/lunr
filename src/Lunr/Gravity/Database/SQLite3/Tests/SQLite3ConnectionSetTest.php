<?php

/**
 * This file contains the SQLite3ConnectionSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;

/**
 * This class contains test for the setters of the SQLite3Connection class.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionSetTest extends SQLite3ConnectionTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->emptySetUp();
    }

    /**
     * Test that set_configuration sets database correctly.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::set_configuration
     */
    public function testSetConfigurationSetsDatabaseCorrectly(): void
    {

        $this->configuration->expects($this->any())
                           ->method('offsetGet')
                           ->with('db')
                           ->will($this->returnValue([ 'file' => NULL ]));

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
    public function testSetConfigurationDoesNotSetDatabase(): void
    {

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->with('db')
                            ->will($this->returnValue([ 'file' => NULL ]));

        $this->set_reflection_property_value('db', '');

        $method = $this->get_accessible_reflection_method('set_configuration');

        $method->invoke($this->class);

        $this->assertEquals(':memory:', $this->get_reflection_property_value('db'));
    }

}

?>
