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

    public function testpreparedatakeys()
    {

    }

}


?>
