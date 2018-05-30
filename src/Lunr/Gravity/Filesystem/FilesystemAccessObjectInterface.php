<?php

/**
 * Filesystem Access Object interface.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem;

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
    public function get_list_of_directories($directory);

    /**
     * Get a list of all non-dot files in a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of files in that directory
     */
    public function get_list_of_files($directory);

    /**
     * Get a listing of the contents of a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of contents of that directory
     */
    public function get_directory_listing($directory);

    /**
     * Find a file in a given directory.
     *
     * @param string $needle   Filename to look for
     * @param string $haystack Base directory to search in
     *
     * @return mixed $return Path of the file if found,
     *                       FALSE on failure
     */
    public function find_matches($needle, $haystack);

    /**
     * Get the contents of a given file.
     *
     * @param string $file Filepath
     *
     * @return mixed $contents Contents of the given file as String on success,
     *                         FALSE on failure
     */
    public function get_file_content($file);

    /**
     * Write contents into file.
     *
     * @param string $file     Filepath
     * @param string $contents Contents to write
     *
     * @return mixed $return Written bytes as integer on success,
     *                       FALSE on failure
     */
    public function put_file_content($file, $contents);

    /**
     * Recursively removes a directory and its contents.
     *
     * @param string $dir_path The directory path to be removed
     *
     * @return boolean TRUE when directory is removed and FALSE in a failure.
     */
    public function rmdir($dir_path);

    /**
     * Turns the values of an array into csv and writes them in a given file.
     *
     * @param  string $file      The filepath to write the file
     * @param  array  $data      An array with the data to be turned into csv
     * @param  string $delimiter The delimiter for the csv (optional)
     * @param  string $enclosure The enclosure for the csv (option)
     *
     * @return boolean TRUE when file is created and FALSE in failure.
     */
    public function put_csv_file_content($file, $data, $delimiter = ',', $enclosure = '"');

    /**
     * Creates a directory with the given name, if it does not exist.
     *
     * This method is a wrapper of the php mkdir.
     *
     * @param string  $pathname  The directory path/name
     * @param integer $mode      The access mode (0755 by default)
     * @param boolean $recursive Allows the creation of nested directories specified in the pathname
     *
     * @return boolean TRUE when directory is created or FALSE in failure.
     */
    public function mkdir($pathname, $mode = 0755, $recursive = FALSE);

    /**
     * Generate a temporary file and return the path.
     *
     * @param string|null $prefix The prefix to the temp file
     *
     * @return bool|string
     */
    public function get_tmp_file($prefix = NULL);

    /**
     * Remove a file.
     *
     * @param string $file Filepath
     *
     * @return bool
     */
    public function rm($file);

}

?>
