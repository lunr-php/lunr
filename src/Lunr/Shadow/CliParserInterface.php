<?php

/**
 * This file contains an interface for command line argument parsers.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow;

/**
 * Command line argument parser interface.
 */
interface CliParserInterface
{

    /**
     * Parse command line parameters.
     *
     * @return array $args Array of parameters and their arguments
     */
    public function parse();

    /**
     * Check whether the parsed command line was valid or not.
     *
     * @return bool $invalid TRUE if the command line was invalid, FALSE otherwise
     */
    public function is_invalid_commandline();

}

?>
