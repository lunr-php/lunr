<?php

/**
 * File logging class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

/**
 * Class for logging messages in files.
 */
class FileLogger extends AbstractLogger
{

    /**
     * Shared instance of the FilesystemAccessObject
     * @var \Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface
     */
    private $fao;

    /**
     * Filename of the logfile.
     * @var String
     */
    private $filename;

    /**
     * Constructor.
     *
     * @param String                                                   $filename Filename of the target log-file.
     * @param \Lunr\Core\DateTime                                      $datetime Instance of the DateTime class.
     * @param \Lunr\Corona\RequestInterface                            $request  Shared instance of the Request class.
     * @param \Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface $fao      Shared instance of the FilesystemAccessObject
     */
    public function __construct($filename, $datetime, $request, $fao)
    {
        parent::__construct($request, $datetime);

        $this->filename = $filename;
        $this->fao      = $fao;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->fao);
        unset($this->filename);

        parent::__destruct();
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   Log level (severity)
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $message = strtoupper($level) . ': ' . (string) $message;
        $msg     = $this->compose_timestamped_message($message, $context);

        $this->fao->put_file_content($this->filename, $msg . "\n", TRUE);
    }

}

?>
