<?php

/**
 * This file contains the request abstraction class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;
use RuntimeException;

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
    protected array $request;

    /**
     * Stored $_FILES values
     * @var array<string,array<string,mixed>>
     */
    protected readonly array $files;

    /**
     * Stored php://input values
     * @var string
     */
    protected string $rawData;

    /**
     * Stored command line arguments
     * @var array<string,string|null>
     */
    protected readonly array $cliArgs;

    /**
     * Shared instance of the request parser.
     * @var RequestParserInterface
     */
    protected readonly RequestParserInterface $parser;

    /**
     * Set of registered request value parsers.
     * @var array<class-string,RequestValueParserInterface>
     */
    protected array $parsers;

    /**
     * The request values to mock.
     * @var array<string,mixed>
     */
    private array $mock;

    /**
     * Constructor.
     *
     * @param RequestParserInterface $parser Shared instance of a Request Parser class
     */
    public function __construct($parser)
    {
        $this->parser  = $parser;
        $this->parsers = [];

        $this->request = $parser->parse_request();
        $this->server  = $parser->parse_server();
        $this->post    = $parser->parse_post();
        $this->get     = $parser->parse_get();
        $this->cookie  = $parser->parse_cookie();
        $this->files   = $parser->parse_files();
        $this->cliArgs = $parser->parse_command_line_arguments();
        $this->rawData = '';

        $this->mock = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // Intentionally not unsetting request value properties, since
        // that may break access to them during PHP shutdown.
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
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return scalar The requested value
     */
    public function get(BackedEnum&RequestValueInterface $key): bool|float|int|string|null
    {
        if (array_key_exists($key->value, $this->mock))
        {
            return $this->mock[$key->value];
        }

        if (array_key_exists($key->value, $this->request))
        {
            return $this->request[$key->value];
        }

        if (!isset($this->parsers[$key::class]))
        {
            throw new RuntimeException('No parser registered for requested value ("' . $key->value . '")!');
        }

        $this->request[$key->value] = $this->parsers[$key::class]->get($key);

        return $this->request[$key->value];
    }

    /**
     * Register a request value parser.
     *
     * @param RequestValueParserInterface $parser A request value parser
     *
     * @return void
     */
    public function registerParser(RequestValueParserInterface $parser): void
    {
        $this->parsers[$parser->getRequestValueType()] = $parser;
    }

    /**
     * Override request values detected from the request parser.
     * Replace all previous mock values.
     *
     * @deprecated Use setMockValues() instead
     *
     * @param array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function set_mock_values(array $values): void
    {
        $this->setMockValues($values);
    }

    /**
     * Override request values detected from the request parser.
     * Replace all previous mock values.
     *
     * @param array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function setMockValues(array $values): void
    {
        $this->mock = $values;
    }

    /**
     * Override request values detected from the request parser.
     * Keep previous mock values and replace individual keys.
     *
     * @deprecated Use addMockValues() instead
     *
     * @param array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function add_mock_values(array $values): void
    {
        $this->addMockValues($values);
    }

    /**
     * Override request values detected from the request parser.
     * Keep previous mock values and replace individual keys.
     *
     * @param array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function addMockValues(array $values): void
    {
        foreach ($values as $key => $value)
        {
            $this->mock[$key] = $value;
        }
    }

    /**
     * Returns a CLI option array of value(s).
     *
     * @deprecated Use getOptionData() instead
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_option_data(string $key): mixed
    {
        return $this->getOptionData($key);
    }

    /**
     * Returns a CLI option array of value(s).
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function getOptionData(string $key): mixed
    {
        return $this->getData($key, RequestData::CliArgument);
    }

    /**
     * Returns all CLI options.
     *
     * @return array $return The option and the arguments of the request
     */
    public function get_all_options(): array
    {
        return $this->getAllOptions();
    }

    /**
     * Returns all CLI options.
     *
     * @deprecated Use getAllOptions() instead
     *
     * @return array $return The option and the arguments of the request
     */
    public function getAllOptions(): array
    {
        return $this->getData(type: RequestData::CliOption);
    }

    /**
     * Negotiate & retrieve the client's preferred content type.
     *
     * @deprecated Use getAcceptFormat() instead
     *
     * @param array $supported Array containing the supported content types
     *
     * @return string|null $return The best match of the preferred content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function get_accept_format(array $supported = []): ?string
    {
        return $this->getAcceptFormat($supported);
    }

    /**
     * Negotiate & retrieve the client's preferred content type.
     *
     * @param array $supported Array containing the supported content types
     *
     * @return string|null $return The best match of the preferred content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function getAcceptFormat(array $supported = []): ?string
    {
        return $this->parser->parse_accept_format($supported);
    }

    /**
     * Negotiate & retrieve the clients preferred language.
     *
     * @deprecated Use getAcceptLanguage() instead
     *
     * @param array $supported Array containing the supported languages
     *
     * @return string|null $return The best match of the preferred languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function get_accept_language(array $supported = []): ?string
    {
        return $this->getAcceptLanguage($supported);
    }

    /**
     * Negotiate & retrieve the clients preferred language.
     *
     * @param array $supported Array containing the supported languages
     *
     * @return string|null $return The best match of the preferred languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function getAcceptLanguage(array $supported = []): ?string
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
        return $this->getAcceptCharset($supported);
    }

    /**
     * Negotiate & retrieve the clients preferred charset.
     *
     * @deprecated Use getAcceptCharset() instead
     *
     * @param array $supported Array containing the supported charsets
     *
     * @return string|null $return The best match of the preferred charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function getAcceptCharset(array $supported = []): ?string
    {
        return $this->parser->parse_accept_charset($supported);
    }

    /**
     * Retrieve a stored GET value.
     *
     * @deprecated Use getGetData() instead
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all GET values if no key is provided or NULL if not found.
     */
    public function get_get_data(?string $key = NULL): mixed
    {
        return $this->getGetData($key);
    }

    /**
     * Retrieve a stored GET value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all GET values if no key is provided or NULL if not found.
     */
    public function getGetData(?string $key = NULL): mixed
    {
        return $this->getData($key, RequestData::Get);
    }

    /**
     * Retrieve a stored POST value.
     *
     * @deprecated Use getPostData() instead
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all POST values if no key is provided or NULL if not found.
     */
    public function get_post_data(?string $key = NULL): mixed
    {
        return $this->getPostData($key);
    }

    /**
     * Retrieve a stored POST value.
     *
     * @param string|null $key Key for the value to retrieve
     *
     * @return mixed The value of the key, all POST values if no key is provided or NULL if not found.
     */
    public function getPostData(?string $key = NULL): mixed
    {
        return $this->getData($key, RequestData::Post);
    }

    /**
     * Retrieve a stored SERVER value.
     *
     * @deprecated Use getServerData() instead
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_server_data(string $key): mixed
    {
        return $this->getServerData($key);
    }

    /**
     * Retrieve a stored SERVER value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function getServerData(string $key): mixed
    {
        return $this->getData($key, RequestData::Server);
    }

    /**
     * Retrieve a stored HTTP Header from the SERVER value.
     *
     * @deprecated Use getHttpHeaderData() instead
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_http_header_data(string $key): mixed
    {
        return $this->getHttpHeaderData($key);
    }

    /**
     * Retrieve a stored HTTP Header from the SERVER value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function getHttpHeaderData(string $key): mixed
    {
        return $this->getData($key, RequestData::Header);
    }

    /**
     * Retrieve a stored COOKIE value.
     *
     * @deprecated Use getCookieData() instead
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_cookie_data(string $key): mixed
    {
        return $this->getCookieData($key);
    }

    /**
     * Retrieve a stored COOKIE value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function getCookieData(string $key): mixed
    {
        return $this->getData($key, RequestData::Cookie);
    }

    /**
     * Retrieve a stored FILE value.
     *
     * @deprecated Use getFilesData() instead
     *
     * @param string $key Key for the value to retrieve
     *
     * @return array|null $return The value of the key or NULL if not found
     */
    public function get_files_data(string $key): ?array
    {
        return $this->getFilesData($key);
    }

    /**
     * Retrieve a stored FILE value.
     *
     * @param string $key Key for the value to retrieve
     *
     * @return array|null $return The value of the key or NULL if not found
     */
    public function getFilesData(string $key): ?array
    {
        return $this->getData($key, RequestData::Upload);
    }

    /**
     * Retrieve raw request data.
     *
     * @deprecated Use getRawData() instead
     *
     * @return string $return The raw request data as string
     */
    public function get_raw_data(): string
    {
        return $this->getRawData();
    }

    /**
     * Retrieve raw request data.
     *
     * @return string $return The raw request data as string
     */
    public function getRawData(): string
    {
        return $this->getData(type: RequestData::Raw);
    }

    /**
     * Retrieve request data.
     *
     * @deprecated Use getData() instead
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
        return $this->getData($key, $type);
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
    public function getData(?string $key = NULL, RequestData $type = RequestData::Get): mixed
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
                $httpKey = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
                return $this->server[$httpKey] ?? NULL;
            case RequestData::Raw:
                $input = $this->parser->parse_raw_data();

                if ($input !== FALSE)
                {
                    $this->rawData = $input;
                }

                return $this->rawData;
            case RequestData::CliArgument:
                if ($key === NULL)
                {
                    return $this->cliArgs;
                }

                return $this->cliArgs[$key] ?? NULL;
            case RequestData::CliOption:
                return array_keys($this->cliArgs);
            default:
                return NULL;
        }
    }

}

?>
