<?php

/**
 * This file contains the MySQLQueryEscaperTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the MySQLQueryEscaper class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQLQueryEscaper
 */
abstract class MySQLQueryEscaperTest extends LunrBaseTest
{

    /**
     * Mock instance of the MySQLConnection class.
     * @var MySQLConnection
     */
    protected $db;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->class = new MySQLQueryEscaper($this->db);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->db);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for invalid indices.
     *
     * @return array $indices Array of invalid indices
     */
    public function invalidIndicesProvider()
    {
        $indices   = [];
        $indices[] = [NULL];
        $indices[] = [FALSE];
        $indices[] = ['string'];
        $indices[] = [new \stdClass()];
        $indices[] = [[]];

        return $indices;
    }

    /**
     * Unit Test Data Provider for valid Index Keywords.
     *
     * @return array $keywords Array of valid index keywords.
     */
    public function validIndexKeywordProvider()
    {
        $keywords   = [];
        $keywords[] = ['USE'];
        $keywords[] = ['IGNORE'];
        $keywords[] = ['FORCE'];

        return $keywords;
    }

    /**
     * Unit Test Data Provider for valid Index use definitions.
     *
     * @return array $for Array of valid index use definitions.
     */
    public function validIndexForProvider()
    {
        $for   = [];
        $for[] = ['JOIN'];
        $for[] = ['ORDER BY'];
        $for[] = ['GROUP BY'];
        $for[] = [''];

        return $for;
    }

}

?>
