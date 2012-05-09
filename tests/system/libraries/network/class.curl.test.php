<?php

/**
 * This file contains the CurlTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Network;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Network\Curl
 */
abstract class CurlTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Reflection instance of the Curl class.
     * @var ReflectionClass
     */
    protected $curl_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->curl_reflection = new ReflectionClass('Lunr\Libraries\Network\Curl');
        $this->curl = new Curl();
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->curl_reflection);
        unset($this->curl);
    }

}

?>
