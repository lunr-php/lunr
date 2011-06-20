<?php

/**
 * This file contains an OAuth Connection Class
 * for Facebook.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * Facebook OAuth Connection Class
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class FacebookConnection implements OAuthConnection
{

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __destruct()
    {
        unset($this->token);
    }

    public function login()
    {

    }

    public function get_user_info()
    {

    }

    public function post_message()
    {

    }
}

?>