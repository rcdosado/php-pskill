<?php

namespace PsKillWrapper\Test;

use PsKillWrapper\Event\PsKillEvents;
use PsKillWrapper\PsKillWrapper;
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
     * @param type $length
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

}