<?php

/**
 * This file contains the IniTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Ini;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Ini class.
 *
 * @covers Lunr\Core\Ini
 */
abstract class IniTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUpMain()
    {
        $this->class      = new Ini();
        $this->reflection = new ReflectionClass('Lunr\Core\Ini');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUpSection()
    {
        $this->class      = new Ini('date');
        $this->reflection = new ReflectionClass('Lunr\Core\Ini');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Unit Test Data Provider for shorthand byte strings.
     *
     * @return array $values shorthand byte strings.
     */
    public function shorthandBytesProvider()
    {
        $values   = [];
        $values[] = [ '10', 10 ];
        $values[] = [ '10K', 10240 ];
        $values[] = [ '10M', 10485760 ];
        $values[] = [ '10G', 10737418240 ];

        return $values;
    }

}

?>
