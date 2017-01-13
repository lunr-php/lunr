<?php

/**
 * This file contains the IniGetIntegerForShorthandBytesTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains tests for the get_integer_for_shorthand_bytes() method.
 *
 * @covers Lunr\Core\Ini
 */
class IniGetIntegerForShorthandBytesTest extends IniTest
{

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setupMain();
    }

    /**
     * Test get_integer_for_shorthand_bytes().
     *
     * @param String  $string  Shorthand byte string
     * @param integer $integer Integer bytes
     *
     * @dataProvider shorthandBytesProvider
     * @covers       Lunr\Core\Ini::get_integer_for_shorthand_bytes
     */
    public function testGetIntegerForShorthandBytes($string, $integer)
    {
        $this->assertSame($integer, $this->class->get_integer_for_shorthand_bytes($string));
    }

}

?>
