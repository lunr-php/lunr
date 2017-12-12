<?php

/**
 * Physical filesystem access class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem;

use Lunr\Gravity\DataAccessObjectInterface;
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
class PhysicalFilesystemAccessObject implements DataAccessObjectInterface, FilesystemAccessObjectInterface
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
     * @param String $directory Base directory
     *
     * @return Array $contents List of directory in that directory
     */
    public function get_list_of_directories($directory)
    {
        $directories = array();

        if (is_bool($directory))
        {
            return $directories;
        }

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
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $directory, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
        }

        return $directories;
    }

    /**
     * Get a list of all non-dot files in a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of files in that directory
     */
    public function get_list_of_files($directory)
    {
        $files = array();

        if (is_bool($directory))
        {
            return $files;
        }

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
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $directory, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
        }

        return $files;
    }

    /**
     * Get a listing of the contents of a given directory.
     *
     * @param String $directory Base directory
     *
     * @return Array $contents List of contents of that directory
     */
    public function get_directory_listing($directory)
    {
        $raw_results = scandir($directory, SCANDIR_SORT_NONE);

        return array_diff($raw_results, array('.', '..'));
    }

    /**
     * Find a file in a given directory.
     *
     * @param String $needle   Filename to look for
     * @param String $haystack Base directory to search in
     *
     * @return mixed $return Path of the file if found,
     *                       FALSE on failure
     */
    public function find_matches($needle, $haystack)
    {
        if (is_bool($needle) || is_bool($haystack))
        {
            return array();
        }

        try
        {
            $directory = new RecursiveDirectoryIterator($haystack);
            $iterator  = new RecursiveIteratorIterator($directory);
            $matches   = new RegexIterator($iterator, $needle, RecursiveRegexIterator::GET_MATCH);
        }
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $haystack, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't open directory '{directory}': {message}", $context);
            return FALSE;
        }
        catch(InvalidArgumentException $invalid)
        {
            $context = [ 'message' => $invalid->getMessage() ];
            $this->logger->error('{message}', $context);
            return FALSE;
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
            return array();
        }
        catch(TypeError $runtime)
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
     * @param String $file Filepath
     * @param String $mode The mode in which to open the file. Default: readonly
     *
     * @return mixed $file SplFileObject instance for the path, FALSE on failure
     */
    public function get_file_object($file, $mode = 'r')
    {
        try
        {
            return is_bool($file) ? FALSE : new SplFileObject($file, $mode);
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
        catch(LogicException $logic)
        {
            $context = [ 'message' => $logic->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
        catch(TypeError $e)
        {
            $context = [ 'message' => $e->getMessage() ];
            $this->logger->error('{message}', $context);

            return FALSE;
        }
    }

    /**
     * Get the contents of a given file.
     *
     * @param String $file Filepath
     *
     * @return mixed $contents Contents of the given file as String on success,
     *                         FALSE on failure
     */
    public function get_file_content($file)
    {
        return is_bool($file) ? FALSE : file_get_contents($file);
    }

    /**
     * Write contents into file.
     *
     * @param String  $file           Filepath
     * @param String  $contents       Contents to write
     * @param Boolean $append         Whether to append to an existing file or not
     * @param Boolean $exclusive_lock Whether to acquire an exclusive write lock for the file or not
     *
     * @return mixed $return Written bytes as integer on success,
     *                       FALSE on failure
     */
    public function put_file_content($file, $contents, $append = FALSE, $exclusive_lock = FALSE)
    {
        $flags = 0;

        if ($append === TRUE)
        {
            $flags = $flags | FILE_APPEND;
        }

        if ($exclusive_lock === TRUE)
        {
            $flags = $flags | LOCK_EX;
        }

        return is_bool($file) ? FALSE : file_put_contents($file, $contents, $flags);
    }

    /**
     * Recursively removes a directory and its contents.
     *
     * @param String $dir_path The directory path to be removed
     *
     * @return Boolean TRUE when directory is removed and FALSE in a failure.
     */
    public function rmdir($dir_path)
    {
        try
        {
            $directory = new RecursiveDirectoryIterator($dir_path, FilesystemIterator::SKIP_DOTS);
            $iterator  = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);

            foreach($iterator as $file)
            {
                if($file->isFile())
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
        catch(UnexpectedValueException $unexpected)
        {
            $context = [ 'directory' => $dir_path, 'message' => $unexpected->getMessage() ];
            $this->logger->error("Couldn't recurse on directory '{directory}': {message}", $context);
            return FALSE;
        }
        catch(RuntimeException $runtime)
        {
            $context = [ 'message' => $runtime->getMessage() ];
            $this->logger->warning('{message}', $context);
            return FALSE;
        }
    }

    /**
     * Turns the values of an array into csv and writes them in a given file.
     *
     * @param  String $file      The filepath to write the file
     * @param  Array  $data      An array with the data to be turned into csv
     * @param  String $delimiter The delimiter for the csv (optional)
     * @param  String $enclosure The enclosure for the csv (optional)
     *
     * @return Boolean TRUE when file is created and FALSE in failure.
     */
    public function put_csv_file_content($file, $data, $delimiter = ',', $enclosure = '"')
    {
        $fp = fopen($file, 'w');

        if($fp === FALSE)
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
     * @param String  $pathname  The directory path/name
     * @param Integer $mode      The access mode (0755 by default)
     * @param Boolean $recursive Allows the creation of nested directories specified in the pathname
     *
     * @return Boolean TRUE when directory is created or FALSE in failure.
     */
    public function mkdir($pathname, $mode = 0755, $recursive = FALSE)
    {
        if(is_string($mode))
        {
            $this->logger->warning('String representation of access mode is not supported. Please, try using an integer.');
            return FALSE;
        }

        if(decoct(octdec(strval($mode))) != $mode && $mode > 0)
        {
            $mode = octdec((string) $mode);
        }

        //this is the octal range (0000 - 2777 and 4000 - 4777) in decimal
        if(!(($mode >= 0 && $mode <= 1535) || ($mode >= 2048 && $mode <= 2559)))
        {
            $this->logger->warning('Access mode value ' . $mode . ' is invalid.');
            return FALSE;
        }

        if(mkdir($pathname, $mode, $recursive) === FALSE)
        {
            $this->logger->warning('Failed to create directory: ' . $pathname);
            return FALSE;
        }

        return TRUE;
    }

}

?>
