<?php

/**
 * This file contains User Profile support for Facebook.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook;

use Lunr\Spark\DataError;

/**
 * Facebook User Profile Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class UserProfile extends User
{

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas    Shared instance of the CentralAuthenticationStore class.
     * @param LoggerInterface            $logger Shared instance of a Logger class.
     * @param Curl                       $curl   Shared instance of the Curl class.
     */
    public function __construct($cas, $logger, $curl)
    {
        parent::__construct($cas, $logger, $curl);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Retrieve user profile info.
     *
     * @param String $name      Name of the field to get
     * @param Array  $arguments Arguments passed on call (Ignored)
     *
     * @return mixed $value Field value
     */
    public function __call($name, $arguments)
    {
        $item = str_replace('get_', '', $name);

        if (!empty($this->fields) && !in_array($item, $this->fields))
        {
            return DataError::NOT_REQUESTED;
        }

        $permission = '';

        switch ($item)
        {
            case 'id':
            case 'name':
            case 'first_name':
            case 'middle_name':
            case 'last_name':
            case 'gender':
            case 'locale':
            case 'link':
            case 'username':
                return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
            case 'age_range':
            case 'third_party_id':
            case 'updated_time':
            case 'timezone':
            case 'installed':
            case 'verified':
            case 'currency':
            case 'cover':
            case 'devices':
            case 'payment_pricepoints':
            case 'payment_mobile_pricepoints':
            case 'video_upload_limits':
                if ($this->used_access_token === FALSE)
                {
                    $context = [ 'field' => $item ];
                    $this->logger->warning('Access to "{field}" requires an access token.', $context);

                    return DataError::ACCESS_DENIED;
                }

                return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
            case 'security_settings':
                if ($this->profile_id !== 'me')
                {
                    $context = [ 'field' => $item ];
                    $this->logger->warning('Access to "{field}" only allowed for current user.', $context);

                    return DataError::ACCESS_DENIED;
                }

            case 'picture':
                if (empty($this->fields))
                {
                    $context = [ 'field' => $item ];
                    $this->logger->warning('Access to "{field}" needs to be requested specifically.', $context);

                    return DataError::NOT_REQUESTED;
                }

                return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
            case 'languages':
                $permission = [ 'user_likes' ];
                break;
            case 'bio':
            case 'quotes':
                $permission = [ 'user_about_me', 'friends_about_me' ];
                break;
            case 'birthday':
                $permission = [ 'user_birthday', 'friends_birthday' ];
                break;
            case 'education':
                $permission = [ 'user_education_history', 'friends_education_history' ];
                break;
            case 'email':
                $permission = [ 'email' ];
                break;
            case 'hometown':
                $permission = [ 'user_hometown', 'friends_hometown' ];
                break;
            case 'interested_in':
                $permission = [ 'user_relationship_details', 'friends_relationship_details' ];
                break;
            case 'location':
                $permission = [ 'user_location', 'friends_location' ];
                break;
            case 'political':
            case 'religion':
                $permission = [ 'user_religion_politics', 'friends_religion_politics' ];
                break;
            case 'favorite_athletes':
            case 'favorite_teams':
                $permission = [ 'user_likes', 'friends_likes' ];
                break;
            case 'relationship_status':
            case 'significant_other':
                $permission = [ 'user_relationships', 'friends_relationships' ];
                break;
            case 'website':
                $permission = [ 'user_website', 'friends_website' ];
                break;
            case 'work':
                $permission = [ 'user_work_history', 'friends_work_history' ];
                break;
            default:
                return DataError::UNKNOWN_FIELD;
        }

        return isset($this->data[$item]) ? $this->data[$item] : $this->check_item_access($item, $permission);
    }

    /**
     * Fetch the user profile information from Facebook.
     *
     * @return void
     */
    public function get_data()
    {
        $url = Domain::GRAPH . $this->profile_id;

        $this->fetch_data($url);

        $this->get_permissions();
    }

}

?>
