<?php

/**
 * Filesystem Access Object interface.
 *
 * PHP Version 5.3
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem;

/**
 * Filesystem Access Object interface.
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface FilesystemAccessObjectInterface
{

    /**
     * Get a list of all non-dot directories in a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of directory in that directory
     */
    public function get_list_of_directories($directory);

    /**
     * Get a list of all non-dot files in a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of files in that directory
     */
    public function get_list_of_files($directory);

    /**
     * Get a listing of the contents of a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of contents of that directory
     */
    public function get_directory_listing($directory);

    /**
     * Find a file in a given directory.
     *
     * @param String $needle   Filename to look for
     * @param String $haystack Base directory to search in
     *
     * @return mixed $return Path of the file if found,
     *                       FALSE on failure
     */
    public function find_matches($needle, $haystack);

    /**
     * Get the contents of a given file.
     *
     * @param String $file Filepath
     *
     * @return mixed $contents Contents of the given file as String on success,
     *                         FALSE on failure
     */
    public function get_file_content($file);

    /**
     * Write contents into file.
     *
     * @param String $file     Filepath
     * @param String $contents Contents to write
     *
     * @return mixed $return Written bytes as integer on success,
     *                       FALSE on failure
     */
    public function put_file_content($file, $contents);

}

?>
