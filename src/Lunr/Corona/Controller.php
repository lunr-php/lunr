<?php

/**
 * This file contains an abstract controller class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Controller class
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class Controller
{

    use ErrorEnumTrait;

    /**
     * Shared instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * Shared instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param RequestInterface  $request  Shared instance of the Request class
     * @param Response          $response Shared instance of the Response class
     */
    public function __construct($request, $response)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->error    = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->error);
        unset($this->response);
        unset($this->request);
    }

    /**
     * Handle unimplemented calls.
     *
     * @param String $name      Method name
     * @param array  $arguments Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        $this->set_result('not_implemented', 'Not implemented!');
    }

    /**
     * Store result of the call in the response object.
     *
     * @param String $code_index Index of the return code in the ERROR enum
     * @param String $message    Error Message
     * @param mixed  $info       Additional error information
     *
     * @return void
     */
    protected function set_result($code_index, $message = NULL, $info = NULL)
    {
        if (isset($this->error[$code_index]) === TRUE)
        {
            $this->response->set_return_code($this->request->call, $this->error[$code_index]);
        }

        if ($message !== NULL)
        {
            $this->response->set_error_message($this->request->call, $message);
        }

        if ($info !== NULL)
        {
            $this->response->set_error_info($this->request->call, $info);
        }
    }

}

?>
