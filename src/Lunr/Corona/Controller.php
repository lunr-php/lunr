<?php

/**
 * This file contains an abstract controller class.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * Controller class
 */
abstract class Controller
{

    /**
     * Shared instance of the Request class.
     * @var Request
     */
    protected readonly Request $request;

    /**
     * Shared instance of the Response class.
     * @var Response
     */
    protected readonly Response $response;

    /**
     * Constructor.
     *
     * @param Request  $request  Shared instance of the Request class
     * @param Response $response Shared instance of the Response class
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
        // no-op
    }

    /**
     * Handle unimplemented calls.
     *
     * @param string  $name      Method name
     * @param mixed[] $arguments Arguments passed to the method
     *
     * @return void
     */
    public function __call(string $name, array $arguments): void
    {
        $this->set_result(HttpCode::NOT_IMPLEMENTED, 'Not implemented!');
    }

    /**
     * Store result of the call in the response object.
     *
     * @param int         $code    Return Code
     * @param string|null $message Error Message
     * @param mixed       $info    Additional error information
     *
     * @return void
     */
    protected function set_result(int $code, ?string $message = NULL, mixed $info = NULL)
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
