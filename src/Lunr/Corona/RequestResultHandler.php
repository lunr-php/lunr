<?php

/**
 * This file contains the RequestResultHandler.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Corona\Exceptions\HttpException;
use Psr\Log\LoggerInterface;
use Throwable;

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
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param Request         $request  Instance of the Request class.
     * @param Response        $response Instance of the Response class.
     * @param LoggerInterface $logger   Instance of a Logger class.
     */
    public function __construct($request, $response, $logger)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->logger   = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->response);
        unset($this->logger);
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
        catch (HttpException $e)
        {
            $method = 'log_http_' . $e->getCode();

            $this->$method($e);

            $this->set_result($e->getCode(), $e->getMessage(), $e->getAppCode());
        }
        catch (Throwable $e)
        {
            $this->logger->error($e->getMessage(), [ 'exception' => $e ]);
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
     * @param int    $code    Return Code
     * @param string $message Error Message
     * @param mixed  $info    Additional error information
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
