<?php

namespace PsKillWrapper;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ExecutableFinder;

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
     * @throws \PsKill\PskillException
     *   Throws an exception if the path to the Pskill binary couldn't be resolved
     *   by the ExecutableFinder class.
     */
    public function __construct($pskillBinary = null)
    {

        if (null === $pskillBinary ) {

            // @codeCoverageIgnoreStart
            $finder = new ExecutableFinder();
            $pskillBinary = $finder->find('pskill',null,array(__DIR__,'C:\\windows\\'); );

            if (!$pskillBinary) {
                throw new PsKillException('Unable to find the PsKill executable.');
            }
            // @codeCoverageIgnoreEnd
        }

        $this->setPskillBinary($pskillBinary);
    }

    /**
     * Sets the path to the pskill binary.
     *
     * @param string $gitBinary
     *   Path to the pskill binary.
     *
     * @return PskillWrapper\PskillWrapper
     */
    public function setPskillBinary($pskillBinary)
    {
        $this->pskillBinary = $pskillBinary;
        return $this;
    }

    /**
     * Returns the path to the pskill binary.
     *
     * @return string
     */
    public function getPskillBinary()
    {
        return $this->pskillBinary;
    }

}