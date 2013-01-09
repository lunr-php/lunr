<?php

/**
 * This file contains the DBConReadonlyTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DB
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Database\Tests;

use Lunr\Database\DBCon;

/**
 * This tests Lunr's DBCon class
 *
 * @category   Libraries
 * @package    DB
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Database\DBCon
 */
class DBConReadonlyTest extends PHPUnit_Framework_TestCase
{

    /**
     * Reference to the readonly DBCon Mock class
     * @var MockDBConReadonly
     */
    private $dbcon;

    /**
     * Reference to the Reflection Class for the readonly DBCon Mock class
     * @var ReflectionClass
     */
    private $dbcon_reflection;

    /**
     * Testcase Constructor.
     */
    protected function setUp()
    {
        $this->dbcon_reflection = new ReflectionClass('Lunr\Database\DBCon');
        $this->dbcon            = new MockDBConReadonly();
    }

    /**
     * Testcase Destructor.
     */
    protected function tearDown()
    {
        unset($this->dbcon);
        unset($this->dbcon_reflection);
    }

    /**
     * Tests the escaping and preparation of key names for SQL queries.
     *
     * @dataProvider datasetProvider
     * @covers       Lunr\Database\DBCon::prepare_data
     */
    public function testPrepareDataKeys($data, $result, $ignore)
    {
        $method = $this->dbcon_reflection->getMethod('prepare_data');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->dbcon, array($data, 'keys')));
    }

    /**
     * Tests the escaping and preparation of values for SQL queries.
     *
     * @dataProvider datasetProvider
     * @covers       Lunr\Database\DBCon::prepare_data
     */
    public function testPrepareDataValues($data, $ignore, $result)
    {
        $method = $this->dbcon_reflection->getMethod('prepare_data');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->dbcon, array($data, 'values')));
    }

    /**
     * Unit Test Data Provider for datasets.
     *
     * @return array $data Array of datasets.
     */
    public function datasetProvider()
    {
        $data[] = array(
            array('key' => 'value'),
            '(`key`) ',
            "('value') "
        );

        $data[] = array(
            array(
                'key1' => 'value1',
                'key2' => 'value2'
            ),
            '(`key1`,`key2`) ',
            "('value1','value2') "
        );

        $data[] = array(
            array(
                array(
                    'key1' => 'value1',
                    'key2' => 'value2'
                ),
                array(
                    'key1' => 'value3',
                    'key2' => 'value4'
                )
            ),
            '(`key1`,`key2`) ',
            "('value1','value2') ,('value3','value4') "
        );

        $data[] = array(
            'value1',
            '',
            "('value1') "
        );

        $data[] = array(
            array(
                'key' => NULL
            ),
            '(`key`) ',
            '(NULL ) '
        );

        $data[] = array(
            array(
                'key' => "UNHEX('0056eac2c19411e0826a0050568476fa')"
            ),
            '(`key`) ',
            "(UNHEX('0056eac2c19411e0826a0050568476fa') ) "
        );

        return $data;
    }

}


?>
