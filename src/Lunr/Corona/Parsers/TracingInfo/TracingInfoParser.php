<?php

/**
 * This file contains the request value parser for the tracing info.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\TracingInfo;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for tracing info.
 */
class TracingInfoParser implements RequestValueParserInterface
{

    /**
     * The parsed trace ID.
     * @var string
     */
    protected readonly string $traceID;

    /**
     * The parsed span ID.
     * @var string
     */
    protected readonly string $spanID;

    /**
     * Whether to generate UUIDs as hex string or real UUIDs.
     * @var bool
     */
    protected readonly bool $uuidAsHexString;

    /**
     * Constructor.
     *
     * @param bool $uuidAsHexString Whether to generate UUIDs as hex string or real UUIDs
     */
    public function __construct($uuidAsHexString = TRUE)
    {
        $this->uuidAsHexString = $uuidAsHexString;
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
        return TracingInfoValue::class;
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
        // Request ID is an alias for Trace ID
        return match ($key) {
            TracingInfoValue::TraceID,
            TracingInfoValue::RequestID    => $this->traceID ?? $this->parseTraceID(),
            TracingInfoValue::SpanID       => $this->spanID ?? $this->parseSpanID(),
            TracingInfoValue::ParentSpanID => NULL,
            default                        => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the trace ID.
     *
     * @return string|null The parsed bearer token
     */
    protected function parseTraceId(): ?string
    {
        if (array_key_exists('REQUEST_ID', $_SERVER))
        {
            $this->traceID = $_SERVER['REQUEST_ID'];
        }
        else
        {
            $uuid = uuid_create();

            if ($this->uuidAsHexString)
            {
                $uuid = str_replace('-', '', $uuid);
            }

            $this->traceID = $uuid;
        }

        return $this->traceID;
    }

    /**
     * Parse the span ID.
     *
     * @return string|null The parsed bearer token
     */
    protected function parseSpanId(): ?string
    {
        $uuid = uuid_create();

        if ($this->uuidAsHexString)
        {
            $uuid = str_replace('-', '', $uuid);
        }

        $this->spanID = $uuid;

        return $this->spanID;
    }

}

?>
