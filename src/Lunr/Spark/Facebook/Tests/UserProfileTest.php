<?php

/**
 * This file contains the UserProfileTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\UserProfile;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook UserProfile class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\UserProfile
 */
abstract class UserProfileTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Mock instance of the Logger class
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the CurlResponse class.
     * @var CurlResponse
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->curl     = $this->getMock('Lunr\Network\Curl');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Spark\Facebook\UserProfile')
                            ->setConstructorArgs([ $this->cas, $this->logger, $this->curl ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Spark\Facebook\UserProfile');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
        unset($this->curl);
        unset($this->logger);
        unset($this->response);
    }

    /**
     * Unit test data provider for public fields.
     *
     * @return array $fields Array of fields.
     */
    public function publicFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'id' ];
        $fields[] = [ 'name' ];
        $fields[] = [ 'first_name' ];
        $fields[] = [ 'middle_name' ];
        $fields[] = [ 'last_name' ];
        $fields[] = [ 'gender' ];
        $fields[] = [ 'locale' ];
        $fields[] = [ 'link' ];
        $fields[] = [ 'username' ];

        return $fields;
    }

    /**
     * Unit test data provider for fields that require an access token.
     *
     * @return array $fields Array of fields.
     */
    public function accessTokenFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'age_range' ];
        $fields[] = [ 'third_party_id' ];
        $fields[] = [ 'updated_time' ];
        $fields[] = [ 'timezone' ];
        $fields[] = [ 'installed' ];
        $fields[] = [ 'verified' ];
        $fields[] = [ 'currency' ];
        $fields[] = [ 'cover' ];
        $fields[] = [ 'devices' ];
        $fields[] = [ 'payment_pricepoints' ];
        $fields[] = [ 'payment_mobile_pricepoints' ];
        $fields[] = [ 'video_upload_limits' ];

        return $fields;
    }

    /**
     * Unit test data provider for fields that require special permissions.
     *
     * @return array $fields Array of fields.
     */
    public function permissionFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'languages', 'user_likes' ];
        $fields[] = [ 'bio', 'user_about_me' ];
        $fields[] = [ 'bio', 'friends_about_me' ];
        $fields[] = [ 'quotes', 'user_about_me' ];
        $fields[] = [ 'quotes', 'friends_about_me' ];
        $fields[] = [ 'birthday', 'user_birthday' ];
        $fields[] = [ 'birthday', 'friends_birthday' ];
        $fields[] = [ 'education', 'user_education_history' ];
        $fields[] = [ 'education', 'friends_education_history' ];
        $fields[] = [ 'email', 'email' ];
        $fields[] = [ 'hometown', 'user_hometown' ];
        $fields[] = [ 'hometown', 'friends_hometown' ];
        $fields[] = [ 'interested_in', 'user_relationship_details' ];
        $fields[] = [ 'interested_in', 'friends_relationship_details' ];
        $fields[] = [ 'location', 'user_location' ];
        $fields[] = [ 'location', 'friends_location' ];
        $fields[] = [ 'political', 'user_religion_politics' ];
        $fields[] = [ 'political', 'friends_religion_politics' ];
        $fields[] = [ 'religion', 'user_religion_politics' ];
        $fields[] = [ 'religion', 'friends_religion_politics' ];
        $fields[] = [ 'favorite_athletes', 'user_likes' ];
        $fields[] = [ 'favorite_athletes', 'friends_likes' ];
        $fields[] = [ 'favorite_teams', 'user_likes' ];
        $fields[] = [ 'favorite_teams', 'friends_likes' ];
        $fields[] = [ 'relationship_status', 'user_relationships' ];
        $fields[] = [ 'relationship_status', 'friends_relationships' ];
        $fields[] = [ 'significant_other', 'user_relationships' ];
        $fields[] = [ 'significant_other', 'friends_relationships' ];
        $fields[] = [ 'website', 'user_website' ];
        $fields[] = [ 'website', 'friends_website' ];
        $fields[] = [ 'work', 'user_work_history' ];
        $fields[] = [ 'work', 'friends_work_history' ];

        return $fields;
    }

    /**
     * Unit test data provider for requested fields.
     *
     * @return array $fields Array of fields.
     */
    public function requestedFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'security_settings' ];
        $fields[] = [ 'picture' ];

        return $fields;
    }

}

?>
