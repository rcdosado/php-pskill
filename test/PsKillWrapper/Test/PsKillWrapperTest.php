<?php

namespace PsKillWrapper\Test;

use PsKillWrapper\PsKillWrapper;
use PsKillWrapper\PsKillException;


class PsKillWrapperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \PsKillWrapper\PsKillWrapper
     */
	protected $wrapper;

    /**
     * Overrides PHPUnit_Framework_TestCase::setUp().
     */
    public function setUp() {
      parent::setUp();

    }
    public function testIfGetSetBinaryLocationCorrect()
    {
		$binary = 'c:\\windows\\pskill.exe';
        $this->wrapper = new PsKillWrapper($binary);       
        $this->assertEquals($binary, $this->wrapper->getPskillBinary());
    }


    public function testIfNoPsKillLocationGiven()
    {
       $this->wrapper = new PsKillWrapper();
	   $this->assertEquals(NULL,$this->wrapper->getPskillBinary());
    }

}

