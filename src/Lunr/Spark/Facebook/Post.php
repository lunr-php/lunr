<?php

/**
 * This file contains Posts support for Facebook.
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
 * Facebook Posts Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Post extends User
{

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas    Shared instance of the credentials store
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
            case 'from':
            case 'to':
            case 'message':
            case 'message_tags':
            case 'picture':
            case 'link':
            case 'name':
            case 'caption':
            case 'description':
            case 'source':
            case 'properties':
            case 'icon':
            case 'actions':
            case 'type':
                if ($this->used_access_token === FALSE)
                {
                    $context = [ 'field' => $item ];
                    $this->logger->warning('Access to "{field}" requires an access token.', $context);

                    return DataError::ACCESS_DENIED;
                }

                return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
            case 'privacy':
            case 'place':
            case 'story':
            case 'story_tags':
            case 'with_tags':
            case 'object_id':
            case 'application':
            case 'created_time':
            case 'updated_time':
            case 'shares':
            case 'include_hidden':
            case 'status_type':
                $permission = [ 'read_stream' ];
                break;
            default:
                return DataError::UNKNOWN_FIELD;
        }

        return isset($this->data[$item]) ? $this->data[$item] : $this->check_item_access($item, $permission);
    }

    /**
     * Inject a previously fetched Facebook post.
     *
     * @param array   $post              Facebook post data
     * @param array   $permissions       Permissions of the user who fetched the post
     * @param Boolean $used_access_token Whether an access token was used for fetching the post or not
     *
     * @return Post $self Self Reference
     */
    public function set_data($post, $permissions, $used_access_token)
    {
        if (isset($post['comments']))
        {
            unset($post['comments']);
        }

        if (isset($post['likes']))
        {
            unset($post['likes']);
        }

        $this->data        = $post;
        $this->permissions = $permissions;

        $this->used_access_token = $used_access_token;

        return $this;
    }

}

?>
