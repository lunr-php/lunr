<?php

/**
 * This file contains the DatabaseConnectionTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnection;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseConnection class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseConnection
 */
abstract class DatabaseConnectionTest extends LunrBaseTest
{

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseConnection')
                            ->setConstructorArgs(array(&$this->configuration, &$this->logger))
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->configuration);
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
