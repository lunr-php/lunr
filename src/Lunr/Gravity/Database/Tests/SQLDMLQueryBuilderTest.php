<?php

/**
 * This file contains the SQLDMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\SQLDMLQueryBuilder;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the SQLDMLQueryBuilder class.
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
abstract class SQLDMLQueryBuilderTest extends LunrBaseTest
{

     /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\SQLDMLQueryBuilder')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLDMLQueryBuilder');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

}

?>
