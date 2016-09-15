<?php

namespace PsKillWrapper\Test;

use PsKillWrapper\PsKillWrapper;

use Symfony\Component\EventDispatcher\EventDispatcher;


class TestDispatcher extends EventDispatcher {

}

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
      $this->wrapper = new PsKillWrapper();
    }
    public function testIfGetSetBinaryLocationCorrect()
    {
		$binary = 'c:\\windows\\pskill.exe';
        $this->wrapper->setPskillBinary($binary);
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
        $this->wrapper->CheckIfExisting($dummy);
    }
    public function testIfNoPsKillLocationGiven()
    {
	   $this->assertEquals($this->wrapper->getPsKillLoc(),$this->wrapper->getPskillBinary());
    }

    public function testIfPsKillHelpIsDisplayed()
    {
        $output = $this->wrapper->printPsKillHelp();
        $this->assertNotNull($output);
    }

    public function testSetDispatcher()
    {
        $dispatcher = new TestDispatcher();
        $this->wrapper->setDispatcher($dispatcher);
        $this->assertEquals($dispatcher, $this->wrapper->getDispatcher());
    }

    public function testSetTimeout()
    {
        $timeout = mt_rand(1, 60);
        $this->wrapper->setTimeout($timeout);
        $this->assertEquals($timeout, $this->wrapper->getTimeout());
    }

}

