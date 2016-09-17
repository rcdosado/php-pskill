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

/**
 * @property mixed bypass
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
     * @internal param string $command The Pskill command being run*   The Pskill command being run
     * @internal param $string ...
     *   Zero or more arguments passed to the Pskill command.
     * @internal param array $options An optional array of arguments to pass to the command.*   An optional array of arguments to pass to the command.
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

    /**
     * Returns true if the Git command should be run.
     *
     * The return value is the boolean opposite $this->bypass. Although this
     * seems complex, it makes the code more readable when checking whether the
     * command should be run or not.
     *
     * @return boolean
     *   If true, the command should be run.
     */
    public function notBypassed()
    {
        return !$this->bypass;
    }

    /**
     * Builds the command line options for use in the PsKill command.
     *
     * @return string
     */
    public function buildOptions()
    {
        $options = array();
        foreach ($this->options as $option => $values) {
            foreach ((array) $values as $value) {
                $prefix = (strlen($option) != 1) ? '--' : '-';
                $rendered = $prefix . $option;
                if ($value !== true) {
                    $rendered .= ('--' == $prefix) ? '=' : ' ';
                    $rendered .= ProcessUtils::escapeArgument($value);
                }
                $options[] = $rendered;
            }
        }
        return join(' ', $options);
    }
    /**
     * Sets a command line option.
     *
     * Option names are passed as-is to the command line, whereas the values are
     * escaped using \Symfony\Component\Process\ProcessUtils.
     *
     * @param string $option
     *   The option name, e.g. "branch", "q".
     * @param string|true $value
     *   The option's value, pass true if the options is a flag.
     *
     * @return $this
     *
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
        return $this;
    }

    /**
     * Sets multiple command line options.
     *
     * @param array $options
     *   An associative array of command line options.
     *
     * @return $this
     *
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
        return $this;
    }

    /**
     * Sets a command line flag.
     *
     * @param $option
     * @internal param string $flag The flag name, e.g. "q", "a".*   The flag name, e.g. "q", "a".
     *
     * @return \PsKillWrapper\PsKillCommand
     *
     * @see \PsKillWrapper\PsKillCommand::setOption()
     */
    public function setFlag($option)
    {
        return $this->setOption($option, true);
    }

    /**
     * Gets a command line option.
     *
     * @param string $option
     *   The option name, e.g. "branch", "q".
     * @param mixed $default
     *   Value that is returned if the option is not set, defaults to null.
     *
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return (isset($this->options[$option])) ? $this->options[$option] : $default;
    }

    /**
     * Unsets a command line option.
     *
     * @param string $option
     *   The option name, e.g. "branch", "q".
     *
     * @return \PsKillWrapper\PsKillCommand
     */
    public function unsetOption($option)
    {
        unset($this->options[$option]);
        return $this;
    }

    /**
     * Adds a command line argument passed to the PsKill command.
     *
     * @param string $arg
     *   The argument, e.g. the repo URL, directory, etc.
     *
     * @return \PsKillWrapper\PsKillCommand
     */
    public function addArgument($arg)
    {
        $this->args[] = $arg;
        return $this;
    }
    /**
     * Renders the arguments and options for the PsKill command.
     *
     * @return string
     *
     * @see PsKillCommand::getCommand()
     * @see PsKillCommand::buildOptions()
     */
    public function getCommandLine()
    {
        $command = array(
            $this->getCommand(),
            $this->buildOptions(),
            join(' ', array_map(array('\Symfony\Component\Process\ProcessUtils', 'escapeArgument'), $this->args)),
        );
        return join(' ', array_filter($command));
    }


}
