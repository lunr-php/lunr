<?php

/**
 * This file contains the request value parser for the API version sourced from a cli argument.
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
use Lunr\Shadow\CliParserInterface;
use RuntimeException;

/**
 * Request Value Parser for the API version.
 *
 * @phpstan-import-type CliParameters from CliParserInterface
 */
class ApiVersionCliParser implements RequestEnumValueParserInterface
{

    /**
     * The parsed apiVersion value as enum.
     * @var (BackedEnum&ParsedEnumValueInterface)|null
     */
    protected readonly ?BackedEnum $apiVersion;

    /**
     * Parser CLI argument AST.
     * @var CliParameters
     */
    protected readonly array $params;

    /**
     * The name of the enum to use for API version values.
     * @var class-string<BackedEnum&ParsedEnumValueInterface>
     */
    protected readonly string $enumName;

    /**
     * Constructor.
     *
     * @param class-string<BackedEnum&ParsedEnumValueInterface> $enumName The name of the enum to use for API version values.
     * @param CliParameters                                     $params   Parsed CLI argument AST
     */
    public function __construct(?string $enumName, array $params)
    {
        $this->enumName = $enumName;
        $this->params   = $params;
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

        if (array_key_exists('api-version', $this->params))
        {
            $version = $this->params['api-version'][0];
        }

        $this->apiVersion = call_user_func_array([ $this->enumName, 'tryFromRequestValue' ], [ $version ]);

        return $this->apiVersion;
    }

}

?>
