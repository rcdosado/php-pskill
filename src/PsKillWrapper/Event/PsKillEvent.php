<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/17/2016
 * Time: 9:03 AM
 */

namespace PsKillWrapper\Event;

use PsKillWrapper\PsKillCommand;
use PsKillWrapper\PsKillWrapper;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Process\Process;


class PsKillEvent extends Event {
/**
     * The PsKillWrapper object that likely instantiated this class.
     *
     * @var \PsKillWrapper\PsKillWrapper
     */
    protected $wrapper;

    /**
     * The Process object being run.
     *
     * @var \Symfony\Component\Process\Process
     */
    protected $process;

    /**
     * The PsKillCommand object being executed.
     *
     * @var \PsKillWrapper\PsKillCommand
     */
    protected $command;

    /**
     * Constructs a PsKillEvent object.
     *
     * @param \PsKillWrapper\PsKillWrapper $wrapper
     *   The PsKillWrapper object that likely instantiated this class.
     * @param \Symfony\Component\Process\Process $process
     *   The Process object being run.
     * @param \PsKillWrapper\PsKillCommand $command
     *   The PsKillCommand object being executed.
     */
    public function __construct(PsKillWrapper $wrapper, Process $process, PsKillCommand $command)
    {
        $this->wrapper = $wrapper;
        $this->process = $process;
        $this->command = $command;
    }

    /**
     * Gets the PsKillWrapper object that likely instantiated this class.
     *
     * @return \PsKillWrapper\PsKillWrapper
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * Gets the Process object being run.
     *
     * @return \Symfony\Component\Process\Process
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * Gets the PsKillCommand object being executed.
     *
     * @return \PsKillWrapper\PsKillCommand
     */
    public function getCommand()
    {
        return $this->command;
    }
} 