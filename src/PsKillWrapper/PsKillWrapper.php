<?php

namespace PsKillWrapper;

use Symfony\Component\Process\Process;
//use PsKillWrapper\PskillException;

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

	/**
     * Path to the PsKill Binary.
     *
     * @var string
     */
    protected $pskillBinary;

    /**
     * The timeout of the Git command in seconds, defaults to 60.
     *
     * @var int
     */
    protected $timeout = 60;

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
     * Sets the timeout of the Git command.
     *
     * @param int $timeout
     *   The timeout in seconds.
     *
     * @return \PsKillWrapper\GitWrapper
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int) $timeout;
        return $this;
    }

    /**
     * Gets the timeout of the Git command.
     *
     * @return int
     *   The timeout in seconds.
     */
    public function getTimeout()
    {
        return $this->timeout;
    }


}