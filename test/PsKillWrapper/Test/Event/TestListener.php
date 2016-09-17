<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/17/2016
 * Time: 9:02 AM
 */

namespace PsKillWrapper\Test\Event;

use PsKillWrapper\Event\PsKillEvent;

class TestListener {
    /**
     * The methods that were called.
     *
     * @var array
     */
    protected $methods = array();

    /**
     * The event object passed to the onPrepare method.
     *
     * @var \PsKillWrapper\Event\PsKillEvent
     */
    protected $event;

    public function methodCalled($method)
    {
        return in_array($method, $this->methods);
    }

    /**
     * @return \PsKillWrapper\Event\PsKillEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

} 