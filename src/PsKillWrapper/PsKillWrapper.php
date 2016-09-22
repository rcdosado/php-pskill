<?php

namespace PsKillWrapper;

//use PsKillWrapper\PskillException;
use Symfony\Component\Process\Process;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;


/**
 * A wrapper class around the PsKill.
 *
 */
class PsKillWrapper
{

   /**
     * Symfony event dispatcher object used by this library to dispatch events.
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;


    /*
     * This holds error output whenever pskill command is run
     */
    private $error_output;

	/**
     * Path to the PsKill Binary.
     *
     * @var string
     */
    protected $pskillBinary;

    /**
     * The timeout of the Pskill command in seconds, defaults to 60.
     *
     * @var int
     */
    protected $timeout = 60;

    /**
     * An array of options passed to the proc_open() function.
     *
     * @var array
     */
    protected $procOptions = array();
    /**
     * Constructs a PsKill object.
     *
     * @param string|null $pskillBinary
     *   The path to the pskill binary. Defaults to null, which uses Symfony's
     *   ExecutableFinder to resolve it automatically.
     *
     * @throws \PsKillWrapper\PskillException
     *   Throws an exception if the path to the Pskill binary couldn't be resolved
     *   by the ExecutableFinder class.
     */
    public function __construct($pskillBinary = null)
    {
        if (null === $pskillBinary) {
            $this->CheckIfExisting($this::getPskillLoc());
        }
        $this->setPskillBinary($pskillBinary);
    }

    /**
     * Sets the path to the pskill binary.
     *
     * @param string $pskillBinary
     *   Path to the pskill binary.
     *
     * @return \PsKillWrapper\PsKillWrapper
     */
    public function setPskillBinary($pskillBinary)
    {
        $this->pskillBinary = $pskillBinary;
        return $this;
    }

    /**
     * Returns the path to the pskill binary.
     * first checks if it exists to default directory
	 * then if it exists, then it is set as pskillBinary
     * @return string
     */
    public function getPskillBinary()
    {
		if($this->pskillBinary==NULL)
		{
			if($this->IsPskillInDefaultDirectory())
			$this->pskillBinary = $this->getPskillLoc();
		}
		return $this->pskillBinary;
    }

	/*
	 * Returns the assumed location of pskill
	 */
	 public function getPsKillLoc()
	 {
		 return __DIR__.'\\pskill.exe';
	 }

    /**
     * @return bool
     */
    public function IsPskillInDefaultDirectory()
    {
        return file_exists($this::getPsKillLoc());
    }

    /**
     * @param $loc
     */
    public function CheckIfExisting($loc)
    {
        if (!file_exists($loc)) {
            throw new PskillException('Unable to find the Pskill executable.');
        }
    }

    public function printPsKillHelp(){
        $process = new Process($this->getPsKillLoc());
        $process->run();

        return $process->getOutput();
    }


     /**
     * Gets the dispatcher used by this library to dispatch events.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getDispatcher()
    {
        if (!isset($this->dispatcher)) {
            $this->dispatcher = new EventDispatcher();
        }
        return $this->dispatcher;
    }

    /**
     * Sets the dispatcher used by this library to dispatch events.
     *
     * @param EventDispatcherInterface|\Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     *
     * @return \PsKillWrapper\PsKillWrapper
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

   /**
     * Sets the timeout of the PsKill command.
     *
     * @param int $timeout
     *   The timeout in seconds.
     *
     * @return \PsKillWrapper\PsKillWrapper
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int) $timeout;
        return $this;
    }

    /**
     * Gets the timeout of the pskill command.
     *
     * @return int
     *   The timeout in seconds.
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Sets the options passed to proc_open() when executing the PsKill command.
     *
     * @param array $options
     * @internal param array $timeout The options passed to proc_open().*   The options passed to proc_open().
     *
     * @return \PsKillWrapper\PsKillWrapper
     */
    public function setProcOptions(array $options)
    {
        $this->procOptions = $options;
        return $this;
    }

    /**
     * Gets the options passed to proc_open() when executing the PsKill command.
     *
     * @return array
     */
    public function getProcOptions()
    {
        return $this->procOptions;
    }

     /**
     * Returns the version of the installed PsKill client.
     *
     * @return string
     *
     * @throws \PsKillWrapper\PsKillException
     */
    public function version()
    {
        // PsKill\sv[1-9]\.[0-9][0-9]
        // this is the regex to search for from PsKill
        // must return the version after getting from help file

        //    PsKill v1.15 - Terminates processes on local or remote systems
        //    Copyright (C) 1999-2012  Mark Russinovich
        //    Sysinternals - www.sysinternals.com
        //
        //    Usage: pskill [-t] [\\computer [-u username [-p password]]] <process ID | name>
        //         -t    Kill the process and its descendants.
        //         -u    Specifies optional user name for login to
        //               remote computer.
        //         -p    Specifies optional password for user name. If you omit this
        //               you will be prompted to enter a hidden password.

        $this->pskill('DUMMY');
        $m = array("PsKill vX.XX");
        $banner = trim($this->error_output);
        if($banner)
            preg_match('/^PsKill\sv[1-9]\.[0-9][0-9]/', $banner, $m);
        return $m;
    }


     /**
     * Runs an arbitrary PsKill command.
     *
     * The command is simply a raw command line entry for everything after the
     * PsKill binary. For example, a `pskill config -l` command would be passed as
     * `config -l` via the first argument of this method.
     *
     * Note that no events are thrown by this method.
     *
     * @param string $commandLine
     *   The raw command containing the PsKill options and arguments. The PsKill
     *   binary should not be in the command, for example `pskill config -l` would
     *   translate to "config -l".
     * @param string|null $cwd
     *   The working directory of the PsKill process. Defaults to null which uses
     *   the current working directory of the PHP process.
     *
     * @return string
     *   The STDOUT returned by the PsKill command.
     *
     * @throws \PsKillWrapper\PsKillException
     *
     * @see PsKillWrapper::run()
     */
    public function pskill($commandLine, $cwd = null)
    {
        $command = PsKillCommand::getInstance($commandLine);
        $command->setDirectory($cwd);
        return $this->run($command);
    }

    /**
     * Runs a Pskill command.
     *
     * @param PsKillCommand|PsKillCommand $command
     *   The PsKill command being executed.
     * @param string|null $cwd
     *   Explicitly specify the working directory of the PsKill process. Defaults
     *   to null which automatically sets the working directory based on the
     *   command being executed relative to the working copy.
     *
     * @return string
     *   The STDOUT returned by the PsKill command.
     *
     * @see Process
     */
    public function run(PsKillCommand $command, $cwd = null)
    {
        $wrapper = $this;
        $process = new PsKillProcess($this, $command, $cwd);
        $process->run(function ($type, $buffer) use ($wrapper, $process, $command) {
            $event = new Event\PsKillOutputEvent($wrapper, $process, $command, $type, $buffer);
            $wrapper->getDispatcher()->dispatch(Event\PsKillEvents::PSKILL_OUTPUT, $event);
        });
        $this->error_output = $process->getErrorOutput();
        return $command->notBypassed() ? $process->getOutput() : '';
    }

}