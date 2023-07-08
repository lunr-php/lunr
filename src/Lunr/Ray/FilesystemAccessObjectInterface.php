<?php

/**
 * Filesystem Access Object interface.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray;

/**
 * Filesystem Access Object interface.
 */
interface FilesystemAccessObjectInterface
{

    /**
     * Get a list of all non-dot directories in a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of directory in that directory
     */
    public function get_list_of_directories(string $directory);

    /**
     * Get a list of all non-dot files in a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of files in that directory
     */
    public function get_list_of_files(string $directory);

    /**
     * Get a listing of the contents of a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of contents of that directory
     */
    public function get_directory_listing(string $directory);

    /**
     * Find a file in a given directory.
     *
     * @param string $needle   Filename to look for
     * @param string $haystack Base directory to search in
     *
     * @return mixed $return Path of the file if found,
     *                       FALSE on failure
     */
    public function find_matches(string $needle, string $haystack);

    /**
     * Get the contents of a given file.
     *
     * @param string $file Filepath
     *
     * @return mixed $contents Contents of the given file as String on success,
     *                         FALSE on failure
     */
    public function get_file_content(string $file);

    /**
     * Write contents into file.
     *
     * @param string $file     Filepath
     * @param string $contents Contents to write
     *
     * @return mixed $return Written bytes as integer on success,
     *                       FALSE on failure
     */
    public function put_file_content(string $file, string $contents);

    /**
     * Recursively removes a directory and its contents.
     *
     * @param string $dir_path The directory path to be removed
     *
     * @return bool TRUE when directory is removed and FALSE in a failure.
     */
    public function rmdir(string $dir_path);

    /**
     * Turns the values of an array into csv and writes them in a given file.
     *
     * @param  string $file      The filepath to write the file
     * @param  array  $data      An array with the data to be turned into csv
     * @param  string $delimiter The delimiter for the csv (optional)
     * @param  string $enclosure The enclosure for the csv (option)
     *
     * @return bool TRUE when file is created and FALSE in failure.
     */
    public function put_csv_file_content(string $file, $data, string $delimiter = ',', string $enclosure = '"');

    /**
     * Creates a directory with the given name, if it does not exist.
     *
     * This method is a wrapper of the php mkdir.
     *
     * @param string $pathname  The directory path/name
     * @param int    $mode      The access mode (0755 by default)
     * @param bool   $recursive Allows the creation of nested directories specified in the pathname
     *
     * @return bool TRUE when directory is created or FALSE in failure.
     */
    public function mkdir(string $pathname, int $mode = 0755, bool $recursive = FALSE);

    /**
     * Generate a temporary file and return the path.
     *
     * @param string|null $prefix The prefix to the temp file
     *
     * @return bool|string
     */
    public function get_tmp_file(?string $prefix = NULL);

    /**
     * Remove a file.
     *
     * @param string $file Filepath
     *
     * @return bool
     */
    public function rm(string $file);

}

?>
