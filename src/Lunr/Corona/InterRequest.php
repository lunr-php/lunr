<?php

/**
 * This file contains the InterRequest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * InterRequest class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class InterRequest
{

    /**
     * Reference to the wrapped request object
     * @var RequestInterface
     */
    private $request;

    /**
     * The request values to override.
     * @var array
     */
    private $overridden;

    /**
     * Constructor.
     *
     * @param RequestInterface $request The wrapped request object
     * @param array            $values  The values of the request to override
     */
    public function __construct($request, $values)
    {
        $this->request    = $request;
        $this->overridden = $values;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->overridden);
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
        if(array_key_exists($name, $this->overridden))
        {
            return $this->overridden[$name];
        }

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

}

?>
