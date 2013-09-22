<?php

/**
 * This file contains low level API methods for Facebook.
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

/**
 * Low level Facebook API methods for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class Api
{

    /**
     * Shared instance of the CentralAuthenticationStore
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas Shared instance of the credentials store
     */
    public function __construct($cas)
    {
        $this->cas = $cas;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
    }

    /**
     * Get access to shared credentials.
     *
     * @param String $key Credentials key
     *
     * @return mixed $return Value of the chosen key
     */
    public function __get($key)
    {
        switch ($key)
        {
            case 'app_id':
            case 'app_secret':
            case 'app_secret_proof':
            case 'access_token':
                return $this->cas->get('facebook', $key);
            default:
                return NULL;
        }
    }

    /**
     * Set shared credentials.
     *
     * @param String $key   Key name
     * @param String $value Value to set
     *
     * @return void
     */
    public function __set($key, $value)
    {
        switch ($key)
        {
            case 'app_id':
            case 'app_secret':
                $this->cas->add('facebook', $key, $value);
                break;
            case 'access_token':
                $this->cas->add('facebook', $key, $value);
                $this->cas->add('facebook', 'app_secret_proof', hash_hmac('sha256', $value, $this->app_secret));
                break;
            default:
                break;
        }
    }

}

?>
