<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/22/2016
 * Time: 2:43 PM
 */

namespace PsKillWrapper\Event;


interface PsKillOutputListenerInterface {
        public function handleOutput(PsKillOutputEvent $event);
}