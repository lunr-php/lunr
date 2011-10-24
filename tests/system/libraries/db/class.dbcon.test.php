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

    /**
     * Tests the escaping and preparation of key names for SQL queries
     * @dataProvider datasetProvider
     * @covers Lunr\Libraries\Database\DBCon::prepare_data
     */
    public function testPrepareDataKeys($data, $result)
    {
        $method = $this->dbcon_reflection->getMethod('prepare_data');
        $method->setAccessible(TRUE);
        $this->assertEquals($result, $method->invokeArgs($this->dbcon, array($data, 'keys')));
    }

    public function datasetProvider()
    {
        $data[] = array(
            array(
                "key" => "value"
            ),
            "(`key`) "
        );

        $data[] = array(
            array(
                "key1" => "value1",
                "key2" => "value2"
            ),
            "(`key1`,`key2`) "
        );

        $data[] = array(
            "value1",
            ""
        );

        return $data;
    }

}


?>
