<?php

/**
 * This file contains request data types.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * Request Data Enums
 */
enum RequestData: string
{

    case Get         = 'get';
    case Post        = 'post';
    case Upload      = 'files';
    case Header      = 'header';
    case Cookie      = 'cookie';
    case Server      = 'server';
    case Raw         = 'raw_data';
    case CliArgument = 'cli_args';
    case CliOption   = 'cli_opt';

}

?>
