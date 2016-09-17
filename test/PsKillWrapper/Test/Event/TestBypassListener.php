<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/17/2016
 * Time: 9:26 AM
 */

namespace PsKillWrapper\Test\Event;
use PsKillWrapper\Event\PsKillEvent;

class TestBypassListener {

    public function onPrepare(PsKillEvent $event){
       $event->getCommand()->bypass();
    }

} 