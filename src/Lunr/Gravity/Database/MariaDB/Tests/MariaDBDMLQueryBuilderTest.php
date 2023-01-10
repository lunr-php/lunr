<?php

/**
 * This file contains the MariaDMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MariaDBDMLQueryBuilder class.
 *
 * @covers \Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
 */
abstract class MariaDBDMLQueryBuilderTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class      = new MariaDBDMLQueryBuilder();
        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder');
    }

}

?>
