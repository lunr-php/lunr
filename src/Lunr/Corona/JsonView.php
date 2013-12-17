<?php

/**
 * This file contains the json view class.
 *
 * PHP Version 5.4
 *
 * @category   Library
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * View class for displaying JSON return values.
 *
 * @category   Library
 * @package    Corona
 * @subpackage MVC
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */
class JsonView extends View
{

    /**
     * Constructor.
     *
     * @param RequestInterface $request       Shared instance of the Request class
     * @param Response         $response      Shared instance of the Response class
     * @param Configuration    $configuration Shared instance of to the Configuration class
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

        $json = [];

        $json['data']   = $this->response->get_response_data();
        $json['status'] = [];

        $json['status']['code']    = !is_numeric($info) || is_float($info + 1) ? $code : $info;
        $json['status']['message'] = is_null($msg) ? '' : $msg;

        if ($json['data'] === [])
        {
            $json['data'] = new \stdClass();
        }

        header('Content-type: application/json');
        http_response_code($code);

        if ($this->request->sapi == 'cli')
        {
            echo json_encode($json, JSON_PRETTY_PRINT) . "\n";
        }
        else
        {
            echo json_encode($json);
        }
    }

    /**
     * Build display for Fatal Error output.
     *
     * @return void
     */
    public function print_fatal_error()
    {
        $error = error_get_last();

        if (($error === NULL) || ($error['type'] !== E_ERROR))
        {
            return;
        }

        $json = [];

        $json['data']   = [];
        $json['status'] = [];

        $json['status']['code']    = 500;
        $json['status']['message'] = $error['message'] . " in " . $error['file'] . " on line " . $error['line'];

        header('Content-type: application/json');
        http_response_code(500);

        if ($this->request->sapi == 'cli')
        {
            echo json_encode($json, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n";
        }
        else
        {
            echo json_encode($json, JSON_FORCE_OBJECT);
        }
    }

}

?>
