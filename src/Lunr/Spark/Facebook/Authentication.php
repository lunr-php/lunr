<?php

/**
 * This file contains Authentication support for Facebook.
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

/**
 * Facebook Authentication Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Authentication extends Api
{

    /**
     * CSRF Protection string.
     * @var String
     */
    protected $state;

    /**
     * Authentication verification code.
     * @var String
     */
    protected $code;

    /**
     * URI to redirect to after facebook request.
     * @var String
     */
    protected $redirect_uri;

    /**
     * Additional requested permissions.
     * @var String
     */
    protected $scope;

    /**
     * Unix timestamp of when the access token expires.
     * @var Integer
     */
    protected $token_expires;

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas     Shared instance of the CentralAuthenticationStore class.
     * @param LoggerInterface            $logger  Shared instance of a Logger class.
     * @param Curl                       $curl    Shared instance of the Curl class.
     * @param RequestInterface           $request Shared instance of a Request class.
     */
    public function __construct($cas, $logger, $curl, $request)
    {
        parent::__construct($cas, $logger, $curl);

        $this->state         = $request->get_get_data('state');
        $this->code          = $request->get_get_data('code');
        $this->redirect_uri  = $request->base_url . $request->call;
        $this->scope         = NULL;
        $this->token_expires = 0;

        if ($this->state === NULL)
        {
            $this->state = md5(uniqid(rand(), TRUE));
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->state);
        unset($this->code);
        unset($this->scope);
        unset($this->redirect_uri);
        unset($this->token_expires);
        unset($this->curl);

        parent::__destruct();
    }

    /**
     * Set authentication verification code.
     *
     * @param String $code verification code
     *
     * @return void
     */
    public function set_code($code)
    {
        $this->code = $code;
    }

    /**
     * Set URI to redirect to after a facebook request.
     *
     * @param String $uri URI to redirect to
     *
     * @return void
     */
    public function set_redirect_uri($uri)
    {
        $this->redirect_uri = $uri;
    }

    /**
     * Set additional requested permissions.
     *
     * @param String|array $scope Comma separated list of additional permissions, or array
     *
     * @return void
     */
    public function set_scope($scope)
    {
        if (is_array($scope) === TRUE)
        {
            $this->scope = implode(',', $scope);
        }
        else
        {
            $this->scope = $scope;
        }
    }

    /**
     * Check the CSRF state against a stored state value.
     *
     * @param String $stored_state Stored CSRF state
     *
     * @return Boolean $return TRUE if state matches, FALSE otherwise
     */
    public function is_state_verified($stored_state)
    {
        return $this->state == $stored_state;
    }

    /**
     * Get CSRF state value.
     *
     * @return String $state CSRF state value
     */
    public function get_state()
    {
        return $this->state;
    }

    /**
     * Get authentication verification code.
     *
     * @return String $code Authentication verification code.
     */
    public function get_code()
    {
        return $this->code;
    }

    /**
     * Get the default, short-lived access token.
     *
     * Short-lived access tokens are usually valid for about 2 hours.
     *
     * @return String $access_token Access token
     */
    public function get_temporary_access_token()
    {
        $params = [
            'client_id' => $this->app_id,
            'client_secret' => $this->app_secret,
            'redirect_uri' => $this->redirect_uri,
            'code' => $this->code
        ];

        $url = Domain::GRAPH . 'oauth/access_token';

        $result = $this->get_url_results($url, $params);

        if (empty($result) === TRUE)
        {
            return '';
        }

        $this->access_token  = $result['access_token'];
        $this->token_expires = time() + $result['expires'];

        return $result['access_token'];
    }

    /**
     * Get an application access token.
     *
     * @return String $access_token Access token
     */
    public function get_app_access_token()
    {
        $params = [
            'client_id' => $this->app_id,
            'client_secret' => $this->app_secret,
            'grant_type' => 'client_credentials',
        ];

        $url = Domain::GRAPH . 'oauth/access_token';

        $result = $this->get_url_results($url, $params);

        if (empty($result) === TRUE)
        {
            return '';
        }

        $this->access_token  = $result['access_token'];
        $this->token_expires = 0;

        return $result['access_token'];
    }

    /**
     * Get expiry time for the access token.
     *
     * @return Integer $token_expires Expiry time for the access token.
     */
    public function get_token_expires()
    {
        return $this->token_expires;
    }

    /**
     * Return login URL for facebook.
     *
     * @return String $url Login URL
     */
    public function get_login_url()
    {
        $params = [
            'client_id' => $this->app_id,
            'redirect_uri' => $this->redirect_uri,
            'state' => $this->state
        ];

        if ($this->scope !== NULL)
        {
            $params['scope'] = $this->scope;
        }

        return Domain::WWW . 'dialog/oauth?' . http_build_query($params);
    }

    /**
     * Return logout URL for facebook.
     *
     * @return String $url Logout URL
     */
    public function get_logout_url()
    {
        $params = [
            'next' => $this->redirect_uri,
            'access_token' => $this->access_token
        ];

        return Domain::WWW . 'logout.php?' . http_build_query($params);
    }

}

?>
