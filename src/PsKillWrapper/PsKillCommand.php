<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/17/2016
 * Time: 8:32 AM
 */

namespace PsKillWrapper ;

use Symfony\Component\Process\ProcessUtils;

/*
 * Base class extended by all PsKill Command Classes
 */
class PsKillCommand
{
     /**
     * Path to the directory containing the working copy. If this variable is
     * set, then the process will change into this directory while the PsKill
     * command is being run.
     *
     * @var string|null
     */
    protected $directory;

    /**
     * The command being run
     *
     * @var string
     */
    protected $command = '';

    /**
     * An associative array of command line options and flags.
     *
     * @var array
     */
    protected $options = array();

    /**
     * Command line arguments passed to the Git command.
     *
     * @var array
     */
    protected $args = array();


   /**
     * Constructs a PsKillCommand object.
     *
     * Use PsKillCommand::getInstance() as the factory method for this class.
     *
     * @param array $args
     *   The arguments passed to PsKillCommand::getInstance().
     */
    protected function __construct($args)
    {
        if ($args) {

            // The first argument is the command.
            $this->command = array_shift($args);

            // If the last element is an array, set it as the options.
            $options = end($args);
            if (is_array($options)) {
                $this->setOptions($options);
                array_pop($args);
            }

            // Pass all other method arguments as the Git command arguments.
            foreach ($args as $arg) {
                $this->addArgument($arg);
            }
        }
    }

    /**
     * Constructs a PsKillCommand object.
     *
     * Accepts a variable number of arguments to model the arguments passed to
     * the Pskill command line utility. If the last argument is an array, it is
     * passed as the command options.
     *
     * @param string $command
     *   The Pskill command being run
     * @param string ...
     *   Zero or more arguments passed to the Pskill command.
     * @param array $options
     *   An optional array of arguments to pass to the command.
     *
     * @return \PsKillWrapper\PsKillCommand
     */
    public static function getInstance()
    {
        $args = func_get_args();
        return new static($args);
    }

    /**
     * Returns PsKill command being run
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Sets the path to the directory containing the working copy.
     *
     * @param string $directory
     *   The path to the directory containing the working copy.
     *
     * @return \PsKillWrapper\PsKillCommand
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Gets the path to the directory containing the working copy.
     *
     * @return string|null
     *   The path, null if no path is set.
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * A boolean flagging whether to skip running the command.
     *
     * @param boolean $bypass
     *   Whether to bypass execution of the command. The parameter defaults to
     *   true for code readability, however the default behavior of this class
     *   is to run the command.
     *
     * @return \PsKillWrapper\PsKillCommand
     */
    public function bypass($bypass = true)
    {
        $this->bypass = (bool) $bypass;
        return $this;
    }

}
