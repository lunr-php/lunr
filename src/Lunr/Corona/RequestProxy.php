<?php

/**
 * This file contains the RequestProxy class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * RequestProxy class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class RequestProxy
{

    /**
     * Reference to the wrapped request object
     * @var RequestInterface
     */
    private $request;

    /**
     * Constructor.
     *
     * @param RequestInterface $request The wrapped request object
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to the request keys.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        return $this->request->$name;
    }

    /**
     * Calls the wrapped request methods.
     *
     * @param String $method    the method to call on the wrapped request object
     * @param Array  $arguments Arguments passed
     *
     * @return Mixed $return Value return by the called method on the wrapped request
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->request, $method), $arguments);
    }

    /**
     * Point the proxy to a different Request class.
     *
     * @param RequestInterface $request Request class to proxy to
     *
     * @return void
     */
    public function redirect($request)
    {
        if ($request instanceof RequestInterface || $request instanceof InterRequest)
        {
            $this->request = $request;
        }
    }

}

?>
