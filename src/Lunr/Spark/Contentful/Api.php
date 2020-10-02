<?php

/**
 * This file contains low level API methods for Contentful.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful;

use Requests_Exception;
use Requests_Exception_HTTP;

/**
 * Low level Contentful API methods for Spark
 */
class Api
{

    /**
     * Shared instance of the CentralAuthenticationStore
     * @var \Lunr\Spark\CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Shared instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Space ID
     * @var String
     */
    protected $space;

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Requests_Session                      $http   Shared instance of the Requests_Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        $this->cas    = $cas;
        $this->logger = $logger;
        $this->http   = $http;
        $this->space  = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->http);
        unset($this->space);
    }

    /**
     * Get access to shared credentials.
     *
     * @param string $key Credentials key
     *
     * @return mixed $return Value of the chosen key
     */
    public function __get($key)
    {
        switch ($key)
        {
            case 'access_token':
                return $this->cas->get('contentful', $key);
            default:
                return NULL;
        }
    }

    /**
     * Set shared credentials.
     *
     * @param string $key   Key name
     * @param string $value Value to set
     *
     * @return void
     */
    public function __set($key, $value)
    {
        switch ($key)
        {
            case 'access_token':
                $this->cas->add('contentful', $key, $value);
                break;
            default:
                break;
        }
    }

    /**
     * Set contentful space ID.
     *
     * @param string $space_id Content space ID
     *
     * @return Api $self Self Reference
     */
    public function set_space_id($space_id)
    {
        $this->space = $space_id;

        return $this;
    }

}

?>
