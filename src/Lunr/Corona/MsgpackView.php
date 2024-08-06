<?php

/**
 * This file contains the msgpack view class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Core\Configuration;
use stdClass;
use Throwable;

/**
 * View class for displaying msgpack return values.
 */
class MsgpackView extends View
{

    /**
     * Constructor.
     *
     * @param Request       $request       Shared instance of the Request class.
     * @param Response      $response      Shared instance of the Response class.
     * @param Configuration $configuration Shared instance of the Configuration class.
     */
    public function __construct($request, $response, $configuration)
    {
        parent::__construct($request, $response, $configuration);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Prepare the response data before using it for generating the output.
     *
     * @param mixed $data Response data to prepare.
     *
     * @return mixed $return Prepared response data
     */
    protected function prepare_data($data)
    {
        return $data;
    }

    /**
     * Build the actual display and print it.
     *
     * @return void
     */
    public function print_page()
    {
        $identifier = $this->response->get_return_code_identifiers(TRUE);

        $info = $this->response->get_error_info($identifier);
        $msg  = $this->response->get_error_message($identifier);
        $code = $this->response->get_return_code($identifier);

        $msgpack = [];

        $msgpack['data']   = $this->prepare_data($this->response->get_response_data());
        $msgpack['status'] = [];

        $msgpack['status']['code']    = !is_numeric($info) || is_float($info + 1) ? $code : $info;
        $msgpack['status']['message'] = is_null($msg) ? '' : $msg;

        if ($msgpack['data'] === [])
        {
            $msgpack['data'] = new stdClass();
        }

        header('Content-type: application/msgpack');
        http_response_code($code);

        // replace StdClass `a8737464436c617373` with empty map msgpack code `80`
        // because php cannot generate a real empty map data type, while we do want msgpack to have it.
        echo str_replace(hex2bin('a8737464436c617373'), hex2bin('80'), msgpack_pack($msgpack));
    }

    /**
     * Build display for Fatal Error output.
     *
     * @return void
     */
    public function print_fatal_error()
    {
        $error = error_get_last();

        if ($this->is_fatal_error($error) === FALSE)
        {
            return;
        }

        $msgpack = [];

        $msgpack['data']   = new stdClass();
        $msgpack['status'] = [];

        $msgpack['status']['code']    = 500;
        $msgpack['status']['message'] = $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'];

        header('Content-type: application/msgpack');
        http_response_code(500);

        // replace StdClass `a8737464436c617373` with empty map msgpack code `80`
        // because php cannot generate a real empty map data type, while we do want msgpack to have it.
        echo str_replace(hex2bin('a8737464436c617373'), hex2bin('80'), msgpack_pack($msgpack));
    }

    /**
     * Build display for uncaught exception output.
     *
     * @param Throwable $e Uncaught exception
     *
     * @return void
     */
    public function print_exception($e)
    {
        $msgpack = [];

        $msgpack['data']   = new stdClass();
        $msgpack['status'] = [];

        $msgpack['status']['code']    = 500;
        $msgpack['status']['message'] = sprintf(
            'Uncaught Exception %s: "%s" at %s line %s',
            get_class($e),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
        );

        header('Content-type: application/msgpack');
        http_response_code(500);

        // replace StdClass `a8737464436c617373` with empty map msgpack code `80`
        // because php cannot generate a real empty map data type, while we do want msgpack to have it.
        echo str_replace(hex2bin('a8737464436c617373'), hex2bin('80'), msgpack_pack($msgpack));
    }

}

?>
