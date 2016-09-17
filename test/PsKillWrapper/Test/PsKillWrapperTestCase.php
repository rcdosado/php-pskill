<?php

namespace PsKillWrapper\Test;

use PsKillWrapper\Event\PsKillEvents;
use Symfony\Component\Filesystem\Filesystem;

class PsKillWrapperTestCase extends \PHPUnit_Framework_TestCase
{
    const CONFIG_EMAIL = 'rcdosado@gmail.com';
    const CONFIG_NAME = 'Roy Cyril Dosado';

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var \PsKillWrapper\PsKillWrapper
     */
    protected $wrapper;
}