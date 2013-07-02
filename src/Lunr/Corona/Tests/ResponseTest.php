<?php

/**
 * This file contains the ResponseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Response class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\Response
 */
class ResponseTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class      = new Response();
        $this->reflection = new ReflectionClass('Lunr\Corona\Response');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for invalid return codes.
     *
     * @return array $codes Array of invalid return codes.
     */
    public function invalidReturnCodeProvider()
    {
        $codes   = [];
        $codes[] = ['502'];
        $codes[] = [4.5];
        $codes[] = [TRUE];
        $codes[] = [[]];

        return $codes;
    }

    /**
     * Unit test data provider for attributes accessible over __get.
     *
     * @return array $attrs Array of attribute names and their default values.
     */
    public function validResponseAttributesProvider()
    {
        $attrs   = [];
        $attrs[] = ['view', ''];

        return $attrs;
    }

    /**
     * Unit test data provider for attributes inaccessible over __get.
     *
     * @return array $attrs Array of attribute names.
     */
    public function invalidResponseAttributesProvider()
    {
        $attrs   = [];
        $attrs[] = ['data'];
        $attrs[] = ['errmsg'];
        $attrs[] = ['errinfo'];
        $attrs[] = ['return_code'];

        return $attrs;
    }

}

?>
