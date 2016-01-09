<?php

/**
 * This file contains the MySQLConnectionTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the MySQLConnection class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLConnection
 */
abstract class MySQLConnectionTest extends LunrBaseTest
{

    /**
     * Mock instance of the sub Configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the mysqli class.
     * @var mysqli
     */
    protected $mysqli;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function emptySetUp()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = [
            ['db', $this->sub_configuration],
        ];

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->will($this->returnValueMap($map));

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->mysqli = $this->getMock('\mysqli');

        $this->class = new MySQLConnection($this->configuration, $this->logger, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLConnection');
    }

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $map = [
            ['db', $this->sub_configuration],
        ];

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->will($this->returnValueMap($map));

        $map = [
            ['rw_host', 'rw_host'],
            ['username', 'username'],
            ['password', 'password'],
            ['database', 'database'],
            ['driver', 'mysql'],
        ];

        $this->sub_configuration->expects($this->any())
                                ->method('offsetGet')
                                ->will($this->returnValueMap($map));

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->mysqli = $this->getMock('\mysqli');

        $this->class = new MySQLConnection($this->configuration, $this->logger, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLConnection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->configuration);
        unset($this->logger);
    }

    /**
     * Unit Test Data Provider for strings to escape.
     *
     * @return array $strings Array of strings and their expected escaped value
     */
    public function escapeStringProvider()
    {
        $strings   = [];
        $strings[] = ["'--", "\'--", "\'--"];
        $strings[] = ["\'--", "\\\'--", "\\\'--"];
        $strings[] = ['70%', '70%', '70%'];
        $strings[] = ['test_name', 'test_name', 'test_name'];

        return $strings;
    }

}

?>
