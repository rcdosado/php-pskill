<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/18/2016
 * Time: 10:14 PM
 */

namespace PsKillWrapper;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;


class PsKillProcess extends Process{

    protected $pskill;

    protected $command;

    /**
     * Constructs a PsKillProcess object.
     * @param \PsKillWrapper\PsKillWrapper|PsKillWrapper $pskill
     * @param \PsKillWrapper\PsKillCommand|PsKillCommand $command
     * @param string|null $cwd
     * @throws PsKillException
     */
    public function __construct(PsKillWrapper $pskill, PsKillCommand $command, $cwd = null)
    {
        $this->pskill = $pskill;
        $this->command = $command;

        // Build the command line options, flags, and arguments.
        $binary = ProcessUtils::escapeArgument($pskill->getPsKillBinary());
        $commandLine = rtrim($binary . ' ' . $command->getCommandLine());

        // Resolve the working directory of the PsKill process. Use the directory
        // in the command object if it exists.
        if (null === $cwd) {
            if (null !== $directory = $command->getDirectory()) {
                if (!$cwd = realpath($directory)) {
                    throw new PsKillException('Path to working directory could not be resolved: ' . $directory);
                }
            }
        }

        // Finalize the environment variables, an empty array is converted
        // to null which enherits the environment of the PHP process.
//        $env = $pskill->getEnvVars();
//        if (!$env) {
//            $env = null;
//        }
        $env = "";
        parent::__construct($commandLine, $cwd, $env, null, $pskill->getTimeout(), $pskill->getProcOptions());
    }

} 