<?php

/**
 * This file contains Pages support for Facebook.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook;

use Lunr\Spark\DataError;

/**
 * Facebook Pages Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Page extends User
{

    /**
     * ID of the page.
     * @var String
     */
    protected $page_id;

    /**
     * Page data.
     * @var Array
     */
    protected $data;

    /**
     * Whether to check permissions or not.
     * @var Boolean
     */
    protected $check_permissions;

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

        $this->data    = [];
        $this->page_id = '';

        $this->check_permissions = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->data);
        unset($this->page_id);
        unset($this->check_permissions);

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
            case 'link':
            case 'category':
            case 'is_published':
            case 'can_post':
            case 'likes':
            case 'location':
            case 'phone':
            case 'checkins':
            case 'picture':
            case 'cover':
            case 'website':
            case 'talking_about_count':
            case 'global_brand_parent_page':
            case 'were_here_count':
            case 'company_overview':
            case 'hours':
                return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
            case 'access_token':
                if (empty($this->fields))
                {
                    $context = [ 'field' => $item ];
                    $this->logger->warning('Access to "{field}" needs to be requested specifically.', $context);

                    return DataError::NOT_REQUESTED;
                }

                $permission = [ 'manage_pages' ];
                break;
            default:
                return DataError::UNKNOWN_FIELD;
        }

        if ($this->is_permission_granted($permission) === FALSE)
        {
            $context = [ 'field' => $item, 'permission' => implode(' or ', $permission) ];
            $this->logger->warning('Access to "{field}" requires "{permission}" permission.', $context);

            return DataError::ACCESS_DENIED;
        }

        return isset($this->data[$item]) ? $this->data[$item] : DataError::NOT_AVAILABLE;
    }

    /**
     * Set the page ID.
     *
     * @param String $id Facebook Page ID
     *
     * @return void
     */
    public function set_page_id($id)
    {
        $this->page_id = $id;
    }

    /**
     * Specify the user profile fields that should be retrieved.
     *
     * @param Array $fields Fields to retrieve
     *
     * @return void
     */
    public function set_fields($fields)
    {
        if (is_array($fields) && in_array('access_token', $fields))
        {
            $this->check_permissions = TRUE;
        }
        else
        {
            $this->check_permissions = FALSE;
        }

        parent::set_fields($fields);
    }

    /**
     * Fetch the page information from Facebook.
     *
     * @return void
     */
    public function get_data()
    {
        if ($this->page_id === '')
        {
            return;
        }

        if ($this->access_token !== NULL)
        {
            $params = [
                'access_token' => $this->access_token,
                'appsecret_proof' => $this->app_secret_proof
            ];
        }
        else
        {
            $params = [];
        }

        if (empty($this->fields) === FALSE)
        {
            $params['fields'] = implode(',', $this->fields);
        }

        $url = Domain::GRAPH . $this->page_id;

        $this->data = $this->get_json_results($url, $params);

        if ($this->check_permissions === TRUE)
        {
            $this->get_permissions();
        }
    }

}

?>
