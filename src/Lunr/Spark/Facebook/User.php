<?php

/**
 * This file contains User support for Facebook.
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
 * Facebook User Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class User extends Api
{

    /**
     * ID or username of the user.
     * @var String
     */
    protected $profile_id;

    /**
     * Granted permissions.
     * @var Array
     */
    protected $permissions;

    /**
     * Whether to check permissions or not.
     * @var Boolean
     */
    protected $check_permissions;

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

        $this->profile_id  = 'me';
        $this->permissions = [];

        $this->check_permissions = TRUE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->profile_id);
        unset($this->permissions);
        unset($this->check_permissions);

        parent::__destruct();
    }

    /**
     * Set the user ID or username.
     *
     * @param String $id Facebook user ID or username
     *
     * @return void
     */
    public function set_profile_id($id)
    {
        $this->profile_id = $id;
    }

    /**
     * Get permissions granted to the access token / application.
     *
     * @return void
     */
    protected function get_permissions()
    {
        if (($this->access_token === NULL) || ($this->check_permissions === FALSE) || (stripos($this->access_token, '|') !== FALSE))
        {
            return;
        }

        $params = [
            'access_token' => $this->access_token
        ];

        $url = Domain::GRAPH . $this->profile_id . '/permissions';

        $result = $this->get_json_results($url, $params);

        if (!empty($result) && isset($result['data']) && isset($result['data'][0]))
        {
            $this->permissions = $result['data'][0];
        }
        else
        {
            $this->permissions = [];
        }
    }

    /**
     * Check whether a set of permissions is granted.
     *
     * @param string|array $permissions Permission string or set of permissions.
     *
     * @return Boolean $return TRUE if permissions are granted, FALSE otherwise
     */
    protected function is_permission_granted($permissions)
    {
        if (is_array($permissions) === FALSE)
        {
            return isset($this->permissions[$permissions]) && ($this->permissions[$permissions] === 1);
        }

        foreach ($permissions as $permission)
        {
            if (array_key_exists($permission, $this->permissions) && ($this->permissions[$permission] === 1))
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Check whether access to a given info item is allowed.
     *
     * @param String       $item       Info item identifier
     * @param String|array $permission Permission string or set of permissions.
     *
     * @return String $error Access Denied if permissions are not granted, Not Available otherwise
     */
    protected function check_item_access($item, $permission)
    {
        if ($this->is_permission_granted($permission) === FALSE)
        {
            $context = [ 'field' => $item, 'permission' => implode(' or ', is_array($permission) ? $permission : [ $permission ]) ];
            $this->logger->warning('Access to "{field}" requires "{permission}" permission.', $context);

            return DataError::ACCESS_DENIED;
        }
        else
        {
            return DataError::NOT_AVAILABLE;
        }
    }

}

?>
