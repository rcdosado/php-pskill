<?php

namespace PsKillWrapper\Event;

/**
 * Event handler that streams real-time output from PsKill commands to STDOUT and
 * STDERR.
 */
class PsKillOutputStreamListener implements PsKillOutputListenerInterface
{
    public function handleOutput(PsKillOutputEvent $event)
    {
        $handler = $event->isError() ? STDERR : STDOUT;
        fputs($handler, $event->getBuffer());
    }
}
