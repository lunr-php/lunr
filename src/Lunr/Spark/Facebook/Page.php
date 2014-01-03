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
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas    Shared instance of the CentralAuthenticationStore class.
     * @param LoggerInterface            $logger Shared instance of a Logger class.
     * @param Curl                       $curl   Shared instance of the Curl class.
     */
    public function __construct($cas, $logger, $curl)
    {
        parent::__construct($cas, $logger, $curl);

        $this->check_permissions = FALSE;
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

        return isset($this->data[$item]) ? $this->data[$item] : $this->check_item_access($item, $permission);
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
        if ($this->id === '')
        {
            return;
        }

        $url = Domain::GRAPH . $this->id;

        $this->fetch_data($url);

        $this->get_permissions();
    }

}

?>
