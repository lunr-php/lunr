<?php

/**
 * This file contains the MariaDBConnectionTest class.
 *
 * PHP Version 7.0
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\MariaDBConnection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class contains common constructors/destructors for testing the MariaDBConnection class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBConnection
 */
class MariaDBConnectionTest extends TestCase
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
     */
    public function setUp()
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->will($this->returnValueMap($map));

        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mariadb' ],
        ];

        $this->sub_configuration->expects($this->any())
                                ->method('offsetGet')
                                ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->mysqli = $this->getMockBuilder('\mysqli')->getMock();

        $this->class = new MariaDBConnection($this->configuration, $this->logger, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBConnection');
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

}

?>
