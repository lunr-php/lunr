<?php

/**
 * Physical filesystem access class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray;

use DirectoryIterator;
use RegexIterator;
use UnexpectedValueException;
use InvalidArgumentException;
use RuntimeException;
use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use SplFileObject;
use FilesystemIterator;
use TypeError;

/**
 * Class to access a physical filesystem.
 */
class PhysicalFilesystemAccessObject implements FilesystemAccessObjectInterface
{

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
    }

    /**
     * Get a list of all non-dot directories in a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of directory in that directory
     */
    public function get_list_of_directories(string $directory)
    {
        $directories = [];

        try
        {
            $dir = new DirectoryIterator($directory);
            foreach ($dir as $file)
            {
                if (!$file->isDot() && $file->isDir())
                {
                    $directories[] = $dir->getFilename();
                }
            }
        }
        catch (UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $directory, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
        }
        catch (RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
        }

        return $directories;
    }

    /**
     * Get a list of all non-dot files in a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of files in that directory
     */
    public function get_list_of_files(string $directory)
    {
        $files = [];

        try
        {
            $dir = new DirectoryIterator($directory);
            foreach ($dir as $file)
            {
                if (!$file->isDot() && !$file->isDir())
                {
                    $files[] = $dir->getFilename();
                }
            }
        }
        catch (UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $directory, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
        }
        catch (RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
        }

        return $files;
    }

    /**
     * Get a listing of the contents of a given directory.
     *
     * @param string $directory Base directory
     *
     * @return array $contents List of contents of that directory
     */
    public function get_directory_listing(string $directory)
    {
        $raw_results = scandir($directory, SCANDIR_SORT_NONE);

        return array_diff($raw_results, [ '.', '..' ]);
    }

    /**
     * Find a file in a given directory.
     *
     * @param string $needle   Filename to look for
     * @param string $haystack Base directory to search in
     *
     * @return mixed $return Path of the file if found,
     *                       FALSE on failure
     */
    public function find_matches(string $needle, string $haystack)
    {
        if ($needle === '')
        {
            return FALSE;
        }

        try
        {
            $directory = new RecursiveDirectoryIterator($haystack);
            $iterator  = new RecursiveIteratorIterator($directory);
            $matches   = new RegexIterator($iterator, $needle, RecursiveRegexIterator::GET_MATCH);
        }
        catch (UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $haystack, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
            return FALSE;
        }
        catch (InvalidArgumentException $invalid)
        {
            $context = [ 'message' => $invalid->getMessage() ];
            $this->logger->error('{message}', $context);
            return FALSE;
        }
        catch (RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
            return [];
        }
        catch (TypeError $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->error('{message}', $context);
            return FALSE;
        }

        return array_keys(iterator_to_array($matches));
    }

    /**
     * Get a SplFileObject for a given path.
     *
     * @param string $file Filepath
     * @param string $mode The mode in which to open the file. Default: readonly
     *
     * @return mixed $file SplFileObject instance for the path, FALSE on failure
     */
    public function get_file_object(string $file, string $mode = 'r')
    {
        if ($file === '')
        {
            return FALSE;
        }

        try
        {
            return new SplFileObject($file, $mode);
        }
        catch (RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
        catch (LogicException $logic)
        {
            $context = [ 'message' => $logic->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
        catch (TypeError $e)
        {
            $context = [ 'message' => $e->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
    }

    /**
     * Generate a temporary file and return the path.
     *
     * @param string|null $prefix The prefix to the temp file
     *
     * @return bool|string
     */
    public function get_tmp_file(?string $prefix = NULL)
    {
        $prefix = $prefix ?? uniqid();
        return tempnam(sys_get_temp_dir(), $prefix);
    }

    /**
     * Remove a file.
     *
     * @param string $file Filepath
     *
     * @return bool
     */
    public function rm(string $file)
    {
        return unlink($file);
    }

    /**
     * Get the contents of a given file.
     *
     * @param string $file Filepath
     *
     * @return mixed $contents Contents of the given file as String on success,
     *                         FALSE on failure
     */
    public function get_file_content(string $file)
    {
        if ($file === '')
        {
            return FALSE;
        }

        return file_get_contents($file);
    }

    /**
     * Write contents into file.
     *
     * @param string $file           Filepath
     * @param string $contents       Contents to write
     * @param bool   $append         Whether to append to an existing file or not
     * @param bool   $exclusive_lock Whether to acquire an exclusive write lock for the file or not
     *
     * @return mixed $return Written bytes as integer on success,
     *                       FALSE on failure
     */
    public function put_file_content(string $file, string $contents, bool $append = FALSE, bool $exclusive_lock = FALSE)
    {
        if ($file === '')
        {
            return FALSE;
        }

        $flags = 0;

        if ($append === TRUE)
        {
            $flags = $flags | FILE_APPEND;
        }

        if ($exclusive_lock === TRUE)
        {
            $flags = $flags | LOCK_EX;
        }

        return file_put_contents($file, $contents, $flags);
    }

    /**
     * Recursively removes a directory and its contents.
     *
     * @param string $dir_path The directory path to be removed
     *
     * @return bool TRUE when directory is removed and FALSE in a failure.
     */
    public function rmdir(string $dir_path)
    {
        try
        {
            $directory = new RecursiveDirectoryIterator($dir_path, FilesystemIterator::SKIP_DOTS);
            $iterator  = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($iterator as $file)
            {
                if ($file->isFile())
                {
                    unlink($file->getPathname());
                }
                else
                {
                    rmdir($file->getPathname());
                }
            }

            return rmdir($dir_path);
        }
        catch (UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $dir_path, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't recurse on directory '{directory}': {message}", $context);
            return FALSE;
        }
        catch (RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
            return FALSE;
        }
    }

    /**
     * Turns the values of an array into csv and writes them in a given file.
     *
     * @param  string $file      The filepath to write the file
     * @param  array  $data      An array with the data to be turned into csv
     * @param  string $delimiter The delimiter for the csv (optional)
     * @param  string $enclosure The enclosure for the csv (optional)
     *
     * @return bool TRUE when file is created and FALSE in failure.
     */
    public function put_csv_file_content(string $file, $data, string $delimiter = ',', string $enclosure = '"')
    {
        $fp = fopen($file, 'w');

        if ($fp === FALSE)
        {
            $this->logger->warning('Could not open the file: ' . $file);
            return FALSE;
        }

        foreach ($data as $fields)
        {
            fputcsv($fp, $fields, $delimiter, $enclosure);
        }

        fclose($fp);

        return TRUE;
    }

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
    public function mkdir(string $pathname, $mode = 0755, bool $recursive = FALSE)
    {
        if (is_string($mode))
        {
            $this->logger->warning('String representation of access mode is not supported. Please, try using an integer.');
            return FALSE;
        }

        //this is the octal range (0000 - 2777 and 4000 - 4777) in decimal
        if (!(($mode >= 0 && $mode <= 1535) || ($mode >= 2048 && $mode <= 2559)))
        {
            $this->logger->warning('Access mode value ' . $mode . ' is invalid.');
            return FALSE;
        }

        if (mkdir($pathname, $mode, $recursive) === FALSE)
        {
            $this->logger->warning('Failed to create directory: ' . $pathname);
            return FALSE;
        }

        return TRUE;
    }

}

?>
