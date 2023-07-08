<?php

/**
 * This file contains the request abstraction class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * Request abstraction class.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 *
 * @property-read string $action           The HTTP method used for the request
 * @property-read string $protocol         The protocol used for the request
 * @property-read string $domain           The domain used for the request
 * @property-read string $port             The port used for the request
 * @property-read string $base_url         All of the above combined
 * @property-read string $device_useragent The device specific user agent sent with the request
 * @property-read string $useragent        The user agent sent with the request
 * @property-read string $sapi             The PHP SAPI invoking the code
 * @property-read string $host             The hostname of the server the script is running on
 * @property-read string $controller       The controller requested
 * @property-read string $method           The method requested of that controller
 * @property-read array  $params           The parameters for that method
 * @property-read string $call             The call identifier, combining controller and method
 * @property-read string $verbosity        Logging verbosity
 * @property-read string $id               Unique request ID
 * @property-read string $bearer_token     An authorization token
 */
class Request
{

    /**
     * Stored $_POST values
     * @var array<string,mixed>
     */
    protected $post;

    /**
     * Stored $_GET values
     * @var array<string,mixed>
     */
    protected $get;

    /**
     * Stored $_COOKIE values
     * @var array<string,mixed>
     */
    protected $cookie;

    /**
     * Stored $_SERVER values
     * @var array<string,mixed>
     */
    protected $server;

    /**
     * Request property data
     *
     * @var array<string, mixed>
     */
    protected $request;

    /**
     * Stored $_FILES values
     * @var array<string,array<string,mixed>>
     */
    protected $files;

    /**
     * Stored php://input values
     * @var string
     */
    protected $raw_data;

    /**
     * Stored command line arguments
     * @var array<string,string|null>
     */
    protected $cli_args;

    /**
     * Shared instance of the request parser.
     * @var RequestParserInterface
     */
    protected $parser;

    /**
     * The request values to mock.
     * @var array<string,mixed>
     */
    private $mock;

    /**
     * Constructor.
     *
     * @param RequestParserInterface $parser Shared instance of a Request Parser class
     */
    public function __construct($parser)
    {
        $this->parser = $parser;

        $this->request  = $parser->parse_request();
        $this->server   = $parser->parse_server();
        $this->post     = $parser->parse_post();
        $this->get      = $parser->parse_get();
        $this->cookie   = $parser->parse_cookie();
        $this->files    = $parser->parse_files();
        $this->cli_args = $parser->parse_command_line_arguments();
        $this->raw_data = '';

        $this->mock = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->post);
        unset($this->get);
        unset($this->server);
        unset($this->cookie);
        unset($this->request);
        unset($this->files);
        unset($this->parser);
        unset($this->mock);
        unset($this->raw_data);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to the request keys.
     *
     * @param string $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->request))
        {
            if (array_key_exists($name, $this->mock))
            {
                return $this->mock[$name];
            }
            else
            {
                return $this->request[$name];
            }
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Override request values detected from the request parser.
     * Replace all previous mock values.
     *
     * @param array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function set_mock_values(array $values): void
    {
        $this->mock = $values;
    }

    /**
     * Override request values detected from the request parser.
     * Keep previous mock values and replace individual keys.
     *
     * @param array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function add_mock_values(array $values): void
    {
        foreach ($values as $key => $value)
        {
            $this->mock[$key] = $value;
        }
    }

    /**
     * Returns a CLI option array of value(s).
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_option_data(string $key)
    {
        if (array_key_exists($key, $this->cli_args))
        {
            return $this->cli_args[$key];
        }

        return NULL;
    }

    /**
     * Returns all CLI options.
     *
     * @return array $return The option and the arguments of the request
     */
    public function get_all_options(): array
    {
        return array_keys($this->cli_args);
    }

    /**
     * Negotiate & retrieve the client's preferred content type.
     *
     * @param array $supported Array containing the supported content types
     *
     * @return string|null $return The best match of the preferred content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function get_accept_format(array $supported = []): ?string
    {
        return $this->parser->parse_accept_format($supported);
    }

    /**
     * Negotiate & retrieve the clients preferred language.
     *
     * @param array $supported Array containing the supported languages
     *
     * @return string|null $return The best match of the preferred languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function get_accept_language(array $supported = []): ?string
    {
        return $this->parser->parse_accept_language($supported);
    }

    /**
     * Negotiate & retrieve the clients preferred charset.
     *
     * @param array $supported Array containing the supported charsets
     *
     * @return string|null $return The best match of the preferred charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function get_accept_charset(array $supported = []): ?string
    {
        return $this->parser->parse_accept_charset($supported);
    }

    /**
     * Retrieve a stored GET value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all GET values if no key is provided or NULL if not found.
     */
    public function get_get_data(?string $key = NULL)
    {
        if ($key === NULL)
        {
            if (!array_key_exists('get', $this->mock))
            {
                return $this->get;
            }

            return array_merge($this->get, $this->mock['get']);
        }

        if (array_key_exists('get', $this->mock) && array_key_exists($key, $this->mock['get']))
        {
            return $this->mock['get'][$key];
        }

        return $this->get[$key] ?? NULL;
    }

    /**
     * Retrieve a stored POST value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all POST values if no key is provided or NULL if not found.
     */
    public function get_post_data(?string $key = NULL)
    {
        if ($key === NULL)
        {
            if (!array_key_exists('post', $this->mock))
            {
                return $this->post;
            }

            return array_merge($this->post, $this->mock['post']);
        }

        if (array_key_exists('post', $this->mock) && array_key_exists($key, $this->mock['post']))
        {
            return $this->mock['post'][$key];
        }

        return $this->post[$key] ?? NULL;
    }

    /**
     * Retrieve a stored SERVER value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_server_data(string $key)
    {
        return $this->server[$key] ?? NULL;
    }

    /**
     * Retrieve a stored HTTP Header from the SERVER value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_http_header_data(string $key)
    {
        $http_key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$http_key] ?? NULL;
    }

    /**
     * Retrieve a stored COOKIE value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_cookie_data(string $key)
    {
        return $this->cookie[$key] ?? NULL;
    }

    /**
     * Retrieve a stored FILE value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return array|null $return The value of the key or NULL if not found
     */
    public function get_files_data(string $key): ?array
    {
        return $this->files[$key] ?? NULL;
    }

    /**
     * Retrieve raw request data.
     *
     * @return string $return The raw request data as string
     */
    public function get_raw_data(): string
    {
        $input = $this->parser->parse_raw_data();

        if ($input !== FALSE)
        {
            $this->raw_data = $input;
        }

        return $this->raw_data;
    }

}

?>
