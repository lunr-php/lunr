<?php

use Lunr\Mocks\Libraries\Database\MockDBConReadonly;

/**
 * This tests Lunr's DBCon class
 * @covers Lunr\Libraries\Database\DBCon
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

    protected function setUp()
    {
        $this->dbcon_reflection = new ReflectionClass('Lunr\Libraries\Database\DBCon');
        $this->dbcon = new MockDBConReadonly();
    }

    protected function tearDown()
    {
        unset($this->dbcon);
        unset($this->dbcon_reflection);
    }

    /**
     * Tests the escaping and preparation of key names for SQL queries
     * @dataProvider datasetProvider
     * @covers Lunr\Libraries\Database\DBCon::prepare_data
     */
    public function testPrepareDataKeys($data, $result, $ignore)
    {
        $method = $this->dbcon_reflection->getMethod('prepare_data');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->dbcon, array($data, 'keys')));
    }

    /**
     * Tests the escaping and preparation of values for SQL queries
     * @dataProvider datasetProvider
     * @covers Lunr\Libraries\Database\DBCon::prepare_data
     */
    public function testPrepareDataValues($data, $ignore, $result)
    {
        $method = $this->dbcon_reflection->getMethod('prepare_data');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->dbcon, array($data, 'values')));
    }

    public function datasetProvider()
    {
        $data[] = array(
            array(
                "key" => "value"
            ),
            "(`key`) ",
            "('value') "
        );

        $data[] = array(
            array(
                "key1" => "value1",
                "key2" => "value2"
            ),
            "(`key1`,`key2`) ",
            "('value1','value2') "
        );

        $data[] = array(
            "value1",
            "",
            "('value1') "
        );

        $data[] = array(
            array(
                "key" => NULL
            ),
            "(`key`) ",
            "(NULL ) "
        );

        $data[] = array(
            array(
                "key" => "UNHEX('0056eac2c19411e0826a0050568476fa')"
            ),
            "(`key`) ",
            "(UNHEX('0056eac2c19411e0826a0050568476fa') ) "
        );

        return $data;
    }

}


?>
