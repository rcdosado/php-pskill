<?php

namespace PsKillWrapper\Test;

use PsKillWrapper\Event\PsKillEvents;
use PsKillWrapper\PsKillWrapper;
use PsKillWrapper\Test\Event\TestBypassListener;
use Symfony\Component\Filesystem\Filesystem;
use PsKillWrapper\Test\Event\TestListener;

include_once('event\TestListener.php');

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

    /*
     * Overrides PHPUnit_Framework_TestCase::setUp()
     */

    public function setUp(){
        parent::setUp();
        $this->filesystem = new Filesystem();
        $this->wrapper = new PsKillWrapper();
    }

    /**
     * Generates a random string.
     *
     * @param int|type $length
     *   The string length, defaults to 8 characters.
     *
     * @return string
     *
     * @see http://api.drupal.org/api/drupal/modules%21simpletest%21drupal_web_test_case.php/function/DrupalTestCase%3A%3ArandomName/7
     */
    public function randomString($length = 8)
    {
        $values = array_merge(range(65, 90), range(97, 122), range(48, 57));
        $max = count($values) - 1;
        $str = chr(mt_rand(97, 122));
        for ($i = 1; $i < $length; $i++) {
            $str .= chr($values[mt_rand(0, $max)]);
        }
        return $str;
    }
     /**
     * Adds the test listener for all events, returns the listener.
     *
     * @return \PsKillWrapper\Test\Event\TestListener
     */
    public function addListener()
    {
        $dispatcher = $this->wrapper->getDispatcher();
        $listener = new TestListener();

        $dispatcher->addListener(PsKillEvents::PSKILL_PREPARE, [$listener, 'onPrepare']);
        $dispatcher->addListener(PsKillEvents::PSKILL_SUCCESS, [$listener, 'onSuccess']);
        $dispatcher->addListener(PsKillEvents::PSKILL_ERROR, [$listener, 'onError']);
        $dispatcher->addListener(PsKillEvents::PSKILL_BYPASS, [$listener, 'onBypass']);

        return $listener;
    }
   /**
     * Adds the bypass listener so that PsKill commands are not run.
     *
     * @return \PsKillWrapper\Test\Event\TestBypassListener
     */
    public function addBypassListener()
    {
        $listener = new TestBypassListener();
        $dispatcher = $this->wrapper->getDispatcher();
        $dispatcher->addListener(PsKillEvents::PSKILL_PREPARE, array($listener, 'onPrepare'), -5);
        return $listener;
    }

    /**
     * Asserts if version method returns something, note that version function
     * returns either vX.XX or actual version
     *
     * @param $match
     * @internal param type $version The version returned by the USAGE output which contains the version*   The version returned by the USAGE output which contains the version
     */
    public function assertPsKillVersion($match)
    {
        $this->assertNotEmpty($match);
    }
}