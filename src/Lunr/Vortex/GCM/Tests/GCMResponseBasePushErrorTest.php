<?php

/**
 * This file contains the GCMResponseBasePushErrorTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the GCMResponse class
 * in case of a push notification error.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseBasePushErrorTest extends GCMResponseTest
{

    /**
     * Test constructor behavior for error of push notification in case of invalid JSON.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushErrorInvalidJSON()
    {
        parent::setUp();

        $http_code = 400;
        $content   = 'Field "collapse_key" must be a JSON string: 1463565451';

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn($http_code);

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => "Invalid JSON ({$content})" ]
                     );

        $this->class      = new GCMResponse($this->curl_response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of authentication error.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushErrorAuthenticationError()
    {
        parent::setUp();

        $http_code = 401;
        $content   = 'stuff';

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn($http_code);

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Error with authentication' ]
                     );

        $this->class      = new GCMResponse($this->curl_response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Unit test data provider for internal error http codes.
     *
     * @return Array $data http code
     */
    public function internalErrorHTTPCodeDataProvider()
    {
        $data = [];

        $data[] = [ 500 ];
        $data[] = [ 501 ];
        $data[] = [ 503 ];
        $data[] = [ 599 ];

        return $data;
    }

    /**
     * Test constructor behavior for error of push notification in case of internal error.
     *
     * @param Integer $http_code HTTP code received
     *
     * @dataProvider internalErrorHTTPCodeDataProvider
     * @covers       Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushErrorInternalError($http_code)
    {
        parent::setUp();

        $content = 'stuff';

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn($http_code);

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Internal error' ]
                     );

        $this->class      = new GCMResponse($this->curl_response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::TEMPORARY_ERROR ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Unit test data provider for unknown error http codes.
     *
     * @return Array $data http code
     */
    public function unknownErrorHTTPCodeDataProvider()
    {
        $data = [];

        $data[] = [ 404 ];
        $data[] = [ 403 ];

        return $data;
    }

    /**
     * Test constructor behavior for error of push notification in case of unknown error.
     *
     * @param Integer $http_code HTTP code received
     *
     * @dataProvider unknownErrorHTTPCodeDataProvider
     * @covers       Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushErrorUnknownError($http_code)
    {
        parent::setUp();

        $content = 'stuff';

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn($http_code);

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Unknown error' ]
                     );

        $this->class      = new GCMResponse($this->curl_response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::UNKNOWN ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

}

?>
