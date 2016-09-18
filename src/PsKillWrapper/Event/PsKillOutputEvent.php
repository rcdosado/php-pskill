<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/18/2016
 * Time: 10:33 PM
 */

namespace PsKillWrapper\Event;

use PsKillWrapper\PsKillCommand;
use PsKillWrapper\PsKillWrapper;
use Symfony\Component\Process\Process;

class PsKillOutputEvent extends PsKillEvent{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $buffer;

    /**
     * Constructs a PsKillEvent object.
     *
     * @param \PsKillWrapper\PsKillWrapper|PsKillWrapper $wrapper
     *   The PsKillWrapper object that likely instantiated this class.
     * @param Process|\Symfony\Component\Process\Process $process
     *   The Process object being run.
     * @param \PsKillWrapper\PsKillCommand|PsKillCommand $command
     *   The PsKillCommand object being executed.
     * @param $type
     * @param $buffer
     */
    public function __construct(PsKillWrapper $wrapper, Process $process, PsKillCommand $command, $type, $buffer)
    {
        parent::__construct($wrapper, $process, $command);
        $this->type = $type;
        $this->buffer = $buffer;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * Tests whether the buffer was captured from STDERR.
     */
    public function isError()
    {
        return (Process::ERR == $this->type);
    }

} 