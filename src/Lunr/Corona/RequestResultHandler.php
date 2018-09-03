<?php

/**
 * This file contains the RequestResultHandler.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

use \Lunr\Corona\Exceptions\HttpException;
use \Throwable;

/**
 * RequestResultHandler.
 */
class RequestResultHandler
{

    /**
     * Shared instance of the Request class.
     * @var Request
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
     * @param Request  $request  Instance of the Request class.
     * @param Response $response Instance of the Response class.
     */
    public function __construct($request, $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->response);
    }

    /**
     * Handle unimplemented calls.
     *
     * @param string $name      Method name
     * @param array  $arguments Method arguments
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        // no-op
    }

    /**
     * Handle a request.
     *
     * @param callable $callable Request handler to call
     * @param array    $params   Request parameters to pass to the callable
     *
     * @return void
     */
    public function handle_request($callable, $params)
    {
        try
        {
            call_user_func_array($callable, $params);
        }
        catch(HttpException $e)
        {
            $method = 'log_http_' . $e->getCode();

            $this->$method($e);

            $this->set_result($e->getCode(), $e->getMessage(), $e->getAppCode());
        }
        catch(Throwable $e)
        {
            $this->set_result(HttpCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }

        // default to 200 if no result was set
        if ($this->response->get_return_code() === NULL)
        {
            $this->set_result(HttpCode::OK);
        }
    }

    /**
     * Store result of the call in the response object.
     *
     * @param integer $code    Return Code
     * @param string  $message Error Message
     * @param mixed   $info    Additional error information
     *
     * @return void
     */
    private function set_result($code, $message = NULL, $info = NULL)
    {
        $this->response->set_return_code($this->request->call, $code);

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
