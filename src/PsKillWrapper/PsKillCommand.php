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
}
