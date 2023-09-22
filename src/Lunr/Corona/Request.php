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
    protected readonly array $post;

    /**
     * Stored $_GET values
     * @var array<string,mixed>
     */
    protected readonly array $get;

    /**
     * Stored $_COOKIE values
     * @var array<string,mixed>
     */
    protected readonly array $cookie;

    /**
     * Stored $_SERVER values
     * @var array<string,mixed>
     */
    protected readonly array $server;

    /**
     * Request property data
     *
     * @var array<string, mixed>
     */
    protected readonly array $request;

    /**
     * Stored $_FILES values
     * @var array<string,array<string,mixed>>
     */
    protected readonly array $files;

    /**
     * Stored php://input values
     * @var string
     */
    protected string $raw_data;

    /**
     * Stored command line arguments
     * @var array<string,string|null>
     */
    protected readonly array $cli_args;

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
        unset($this->parser);
        unset($this->mock);
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
    public function get_option_data(string $key): mixed
    {
        return $this->get_data($key, RequestData::CliArgument);
    }

    /**
     * Returns all CLI options.
     *
     * @return array $return The option and the arguments of the request
     */
    public function get_all_options(): array
    {
        return $this->get_data(type: RequestData::CliOption);
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
    public function get_get_data(?string $key = NULL): mixed
    {
        return $this->get_data($key, RequestData::Get);
    }

    /**
     * Retrieve a stored POST value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all POST values if no key is provided or NULL if not found.
     */
    public function get_post_data(?string $key = NULL): mixed
    {
        return $this->get_data($key, RequestData::Post);
    }

    /**
     * Retrieve a stored SERVER value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_server_data(string $key): mixed
    {
        return $this->get_data($key, RequestData::Server);
    }

    /**
     * Retrieve a stored HTTP Header from the SERVER value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_http_header_data(string $key): mixed
    {
        return $this->get_data($key, RequestData::Header);
    }

    /**
     * Retrieve a stored COOKIE value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_cookie_data(string $key): mixed
    {
        return $this->get_data($key, RequestData::Cookie);
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
        return $this->get_data($key, RequestData::Upload);
    }

    /**
     * Retrieve raw request data.
     *
     * @return string $return The raw request data as string
     */
    public function get_raw_data(): string
    {
        return $this->get_data(type: RequestData::Raw);
    }

    /**
     * Retrieve request data.
     *
     * @param string|null $key  Key for the value to retrieve
     * @param RequestData $type Type of the request data
     *
     * @return ($type is RequestData::CliOption ? array :
     *         ($type is RequestData::Raw ? string :
     *         ($type is RequestData::Upload ? array|null : mixed))) Request data value
     */
    public function get_data(?string $key = NULL, RequestData $type = RequestData::Get): mixed
    {
        $property = $type->value;

        switch ($type)
        {
            case RequestData::Get:
            case RequestData::Post:
                if ($key === NULL)
                {
                    if (!array_key_exists($property, $this->mock))
                    {
                        return $this->$property;
                    }

                    return array_merge($this->$property, $this->mock[$property]);
                }

                if (array_key_exists($property, $this->mock) && array_key_exists($key, $this->mock[$property]))
                {
                    return $this->mock[$property][$key];
                }

                return $this->$property[$key] ?? NULL;
            case RequestData::Cookie:
            case RequestData::Upload:
            case RequestData::Server:
                return $this->$property[$key] ?? NULL;
            case RequestData::Header:
                $http_key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
                return $this->server[$http_key] ?? NULL;
            case RequestData::Raw:
                $input = $this->parser->parse_raw_data();

                if ($input !== FALSE)
                {
                    $this->raw_data = $input;
                }

                return $this->raw_data;
            case RequestData::CliArgument:
                if ($key === NULL)
                {
                    return $this->cli_args;
                }

                return $this->cli_args[$key] ?? NULL;
            case RequestData::CliOption:
                return array_keys($this->cli_args);
            default:
                return NULL;
        }
    }

}

?>
