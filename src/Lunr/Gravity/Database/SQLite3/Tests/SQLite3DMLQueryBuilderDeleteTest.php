<?php

/**
 * This file contains the SQLite3DMLQueryBuilderDeleteTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * delete queries.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderDeleteTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test that unknown delete modes are ignored.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::delete_mode
     */
    public function testDeleteModeIgnoresUnknownValues(): void
    {
        $this->class->delete_mode('UNSUPPORTED');
        $value = $this->get_reflection_property_value('delete_mode');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test fluid interface of the delete_mode method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::delete_mode
     */
    public function testDeleteModeReturnsSelfReference(): void
    {
        $return = $this->class->delete_mode('IGNORE');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
