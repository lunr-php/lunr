<?php

/**
 * This file contains the request value parser for the API version sourced from a HTTP header.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ApiVersion;

use BackedEnum;
use Lunr\Corona\ParsedEnumValueInterface;
use Lunr\Corona\RequestEnumValueInterface;
use Lunr\Corona\RequestEnumValueParserInterface;
use Lunr\Corona\RequestValueInterface;
use RuntimeException;

/**
 * Request Value Parser for the API version.
 */
class ApiVersionHttpHeaderParser implements RequestEnumValueParserInterface
{

    /**
     * The parsed apiVersion value as enum.
     * @var (BackedEnum&ParsedEnumValueInterface)|null
     */
    protected readonly ?BackedEnum $apiVersion;

    /**
     * The name of the HTTP header holding the API version info
     * @var string
     */
    protected readonly string $header;

    /**
     * The name of the enum to use for API version values.
     * @var class-string<BackedEnum&ParsedEnumValueInterface>
     */
    protected readonly string $enumName;

    /**
     * Constructor.
     *
     * @param class-string<BackedEnum&ParsedEnumValueInterface> $enumName The name of the enum to use for API version values.
     * @param non-empty-string                                  $header   The name of the HTTP header holding the API version.
     */
    public function __construct(string $enumName, string $header = 'Api-Version')
    {
        $this->enumName = $enumName;
        $this->header   = 'HTTP_' . str_replace('-', '_', strtoupper($header));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Return the request value type the parser handles.
     *
     * @return class-string The FQDN of the type enum the parser handles
     */
    public function getRequestValueType(): string
    {
        return ApiVersionValue::class;
    }

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return string|null The requested value
     */
    public function get(BackedEnum&RequestValueInterface $key): ?string
    {
        return match ($key) {
            ApiVersionValue::ApiVersion => ($this->apiVersion ?? $this->parse())?->value,
            default                     => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Get a request value as an enum.
     *
     * @param BackedEnum&RequestEnumValueInterface $key The identifier/name of the request value to get
     *
     * @return ?BackedEnum The requested value
     */
    public function getAsEnum(BackedEnum&RequestEnumValueInterface $key): ?BackedEnum
    {
        return match ($key) {
            ApiVersionValue::ApiVersion => $this->apiVersion ?? $this->parse(),
            default                     => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the API version value from the HTTP authorization header.
     *
     * @return BackedEnum|null The parsed API version
     */
    protected function parse(): ?BackedEnum
    {
        $version = NULL;

        if (array_key_exists($this->header, $_SERVER))
        {
            $version = $_SERVER[$this->header];
        }

        $this->apiVersion = call_user_func_array([ $this->enumName, 'tryFromRequestValue' ], [ $version ]);

        return $this->apiVersion;
    }

}

?>
