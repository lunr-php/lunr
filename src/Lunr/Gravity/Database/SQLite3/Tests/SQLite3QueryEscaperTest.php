<?php

/**
 * This file contains the SQLite3QueryEscaperTest class.
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

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the SQLite3QueryEscaper class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3QueryEscaper
 */
abstract class SQLite3QueryEscaperTest extends LunrBaseTest
{

    /**
     * Mock instance of the SQLite3Connection class.
     * @var SQLite3Connection
     */
    protected $db;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\SQLite3\SQLite3Connection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->class = new SQLite3QueryEscaper($this->db);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3QueryEscaper');
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
        $keywords[] = ['INDEXED BY'];

        return $keywords;
    }

}

?>
