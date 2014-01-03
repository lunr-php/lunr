<?php

/**
 * This file contains the SQLite3ConnectionTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the SQLite3Connection class.
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
abstract class SQLite3ConnectionTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the SQLite3 class.
     * @var SQLite3
     */
    protected $sqlite3;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function emptySetUp()
    {
        if (extension_loaded('sqlite3') === FALSE)
        {
            $this->markTestSkipped('Extension sqlite3 is required.');
        }

        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('db', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->will($this->returnValueMap($map));

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->sqlite3 = $this->getMock('Lunr\Gravity\Database\SQLite3\LunrSQLite3');

        $this->class = new SQLite3Connection($this->configuration, $this->logger, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3Connection');
    }

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        if (extension_loaded('sqlite3') === FALSE)
        {
            $this->markTestSkipped('Extension sqlite3 is required.');
        }

        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('db', $this->sub_configuration),
        );

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->will($this->returnValueMap($map));

        $map = array(
            array('file', '/tmp/test.db'),
            array('driver', 'sqlite3')
        );

        $this->sub_configuration->expects($this->any())
                                ->method('offsetGet')
                                ->will($this->returnValueMap($map));

        $this->sub_configuration->expects($this->any())
                                ->method('offsetExists')
                                ->with($this->equalTo('file'))
                                ->will($this->returnValue(TRUE));

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->sqlite3 = $this->getMock('Lunr\Gravity\Database\SQLite3\LunrSQLite3');

        $this->class = new SQLite3Connection($this->configuration, $this->logger, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3Connection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->sub_configuration);
        unset($this->configuration);
        unset($this->sqlite3);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for strings to escape.
     *
     * @return array $strings Array of strings and their expected escaped value
     */
    public function escapeStringProvider()
    {
        $strings   = array();
        $strings[] = array('Start', 'Start', 'Start');

        return $strings;
    }

}

?>
