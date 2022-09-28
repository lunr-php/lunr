<?php

/**
 * This file contains the SQLite3ConnectionTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
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
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection
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
     * Mock instance of the SQLite3Result class.
     * @var SQLite3Result
     */
    protected $sqlite3_result;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function emptySetUp(): void
    {
        if (extension_loaded('sqlite3') === FALSE)
        {
            $this->markTestSkipped('Extension sqlite3 is required.');
        }

        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration->expects($this->any())
                            ->method('offsetExists')
                            ->will($this->returnValue(TRUE));

        $this->configuration->expects($this->atLeast(1))
                            ->method('offsetGet')
                            ->with('db')
                            ->will($this->returnValue($this->sub_configuration));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->sqlite3 = $this->getMockBuilder('Lunr\Gravity\Database\SQLite3\LunrSQLite3')->getMock();

        $this->sqlite3_result = $this->getMockBuilder('SQLite3Result')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class = new SQLite3Connection($this->configuration, $this->logger, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3Connection');
    }

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        if (extension_loaded('sqlite3') === FALSE)
        {
            $this->markTestSkipped('Extension sqlite3 is required.');
        }

        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration->expects($this->any())
                            ->method('offsetExists')
                            ->will($this->returnValue(TRUE));

        $this->configuration->expects($this->atLeast(1))
                            ->method('offsetGet')
                            ->with('db')
                            ->will($this->returnValue($this->sub_configuration));

        $this->sub_configuration->expects($this->atLeast(1))
                                ->method('offsetExists')
                                ->will($this->returnValue(TRUE));

        $map = [
            [ 'file', '/tmp/test.db' ],
            [ 'driver', 'sqlite3' ],
        ];

        $this->sub_configuration->expects($this->atLeast(1))
                                ->method('offsetGet')
                                ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->sqlite3 = $this->getMockBuilder('Lunr\Gravity\Database\SQLite3\LunrSQLite3')->getMock();

        $this->sqlite3_result = $this->getMockBuilder('SQLite3Result')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class = new SQLite3Connection($this->configuration, $this->logger, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3Connection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->sub_configuration);
        unset($this->configuration);
        unset($this->sqlite3);
        unset($this->sqlite3_result);
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
        $strings   = [];
        $strings[] = [ 'Start', 'Start', 'Start' ];

        return $strings;
    }

}

?>
