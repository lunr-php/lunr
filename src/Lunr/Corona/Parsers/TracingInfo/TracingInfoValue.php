<?php

/**
 * This file contains the TracingInfoValue enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\TracingInfo;

use Lunr\Corona\RequestValueInterface;

/**
 * Enum for Tracing IDs.
 */
enum TracingInfoValue: string implements RequestValueInterface
{

    /**
     * Request ID (Alias for the Trace ID)
     */
    case RequestID = 'requestID';

    /**
     * Trace ID.
     */
    case TraceID = 'traceID';

    /**
     * Span ID.
     */
    case SpanID = 'spanID';

    /**
     * Parent Span ID.
     */
    case ParentSpanID = 'parentSpanID';

}

?>
