<?php

/**
 * This file contains the VerificationTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Verification
 */
abstract class VerificationTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Verification class
     * @var Verification
     */
    protected $verification;

    /**
     * Reflection instance of the Verification class
     * @var ReflectionClass
     */
    protected $verification_reflection;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of the Logger class.
     * @var Logger
     */
    protected $logger;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Libraries\Core\Configuration');

        $this->logger = $this->getMockBuilder('Lunr\Libraries\Core\Logger')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->verification = new Verification($this->configuration, $this->logger);

        $this->verification_reflection = new ReflectionClass('Lunr\Libraries\Core\Verification');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->verification);
        unset($this->verification_reflection);
        unset($this->configuration);
        unset($this->logger);
    }

}

?>
