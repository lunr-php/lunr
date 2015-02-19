<?php

/**
 * This file contains the LunrSoapClientBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Tests;

/**
 * This class contains basic tests for the LunrSoapClient class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @covers     Lunr\Spark\LunrSoapClient
 */
class LunrSoapClientInitTest extends LunrSoapClientTest
{

    /**
     * Test that __construct constructs empty client.
     *
     * @covers Lunr\Spark\LunrSoapClient::__construct
     */
    public function testConstructConstructsEmptyClient()
    {
        $functions = $this->class->__getFunctions();
        $this->assertEmpty($functions);
    }

    /**
     * Test that init constructs the client.
     *
     * @covers Lunr\Spark\LunrSoapClient::init
     */
    public function testInitConstructsClient()
    {
        $wsdl = TEST_STATICS . '/Spark/hello.wsdl';

        $this->class->init($wsdl, []);

        $functions = $this->class->__getFunctions();
        $this->assertContains('string sayHello(string $firstName)', $functions);
    }

    /**
     * Test init returns a self reference.
     *
     * @covers Lunr\Spark\LunrSoapClient::init
     */
    public function testInitReturnsSelfReference()
    {
        $wsdl = TEST_STATICS . '/Spark/hello.wsdl';

        $value = $this->class->init($wsdl, []);

        $this->assertInstanceOf('Lunr\Spark\LunrSoapClient', $value);
        $this->assertSame($this->class, $value);
    }

}

?>
