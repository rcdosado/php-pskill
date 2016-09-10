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

    public function testIfPsKillNotExist()
    {
        $dummy = 'c:\\some\\foo\\location';
        $stub = $this->createMock(PsKillWrapper::class);
        $stub->method('getPsKillLoc')->willReturn($dummy);
        $this->assertEquals($dummy, $stub->getPsKillLoc());
    }
    /**
     * @expectedException \PsKillWrapper\PsKillException
     */
    public function testPsKillException()
    {
        $dummy = 'c:\\some\\foo\\location';
        $this->wrapper = new PsKillWrapper();
        $this->wrapper->CheckIfExisting($dummy);
    }
    public function testIfNoPsKillLocationGiven()
    {
       $this->wrapper = new PsKillWrapper();
	   $this->assertEquals($this->wrapper->getPsKillLoc(),$this->wrapper->getPskillBinary());
    }


    public function testIfPsKillHelpIsDisplayed()
    {
        $this->wrapper = new PsKillWrapper();
        $output = $this->wrapper->printPsKillHelp();
        $this->assertNotNull($output);
    }

}

