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
     * Runkit simulation code for returning FALSE.
     * @var string
     */
    const CURL_RETURN_FALSE = 'return FALSE;';

    /**
     * Runkit simulation code for returning TRUE.
     * @var string
     */
    const CURL_RETURN_TRUE = 'return TRUE;';

    /**
     * Runkit simulation code for returning error message.
     * @var string
     */
    const CURL_RETURN_ERRMSG = 'return "error";';

    /**
     * Runkit simulation code for returning error code.
     * @var string
     */
    const CURL_RETURN_ERRNO = 'return 10;';

    /**
     * Runkit simulation code for returning the http code.
     * @var string
     */
    const CURL_RETURN_CODE = 'return 404;';

    /**
     * Runkit simulation code for returning info.
     * @var string
     */
    const CURL_RETURN_INFO = 'return "info";';

    /**
     * Runkit simulation code for returning a value.
     * @var string
     */
    const CURL_RETURN_VALUE = 'return "value";';

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

    /**
     * Unit Test Data Provider for valid property values.
     *
     * @return array $properties Array of valid properties of the Curl class
     */
    public function validPropertyProvider()
    {
        $properties   = array();
        $properties[] = array('errno', 0);
        $properties[] = array('errmsg', '');
        $properties[] = array('info', array());
        $properties[] = array('http_code', 0);

        return $properties;
    }

    /**
     * Unit Test Data Provider for invalid Curl options.
     *
     * @return array $options Array of invalid Curl options.
     */
    public function invalidOptionProvider()
    {
        $options   = array();
        $options[] = array('RANDOM_OPTION');
        $options[] = array('C_OPT');
        $options[] = array('CU_OPT');
        $options[] = array('CUR_OPT');
        $options[] = array('curl_OPT');

        return $options;
    }

}

?>
