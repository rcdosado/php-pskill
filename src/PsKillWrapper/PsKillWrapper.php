<?php

namespace PsKillWrapper;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ExecutableFinder;
use PsKillWrapper\PskillException;

/**
 * A wrapper class around the PsKill.
 *
 */
class PsKillWrapper
{
	/**
     * Path to the PsKill Binary.
     *
     * @var string
     */
    protected $pskillBinary;

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
			$loc = $this::getPskillLoc();
            $this->CheckIfExisting($loc);
        }
        $this->setPskillBinary($pskillBinary);
    }

    /**
     * Sets the path to the pskill binary.
     *
     * @param string $pskillBinary
     *   Path to the pskill binary.
     *
     * @return PsKillWrapper\PsKillWrapper
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
			$this->pskillBinary = $this::getPskillLoc();
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

}