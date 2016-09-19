<?php

namespace PsKillWrapper\Test;

use PsKillWrapper\PsKillWrapper;
use PsKillWrapper\Test\Event\TestDispatcher;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;

include_once('event\TestDispatcher.php');

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

    /**
     *
     */
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

    public function testProcOptions()
    {
        $value = (bool)mt_rand(0, 1);
        $options = array('suppress_errors' => $value);
        $this->wrapper->setProcOptions($options);
        $this->assertEquals($options, $this->wrapper->getProcOptions());

    }

    public function testPsKillVersion()
    {
        $version = $this->wrapper->version();
        print_r($version);
//       $this->assertPsKillVersion($version);

//         $user_data_source = 'C:\\dev\\projects\\php-pskill\\src\\PsKillWrapper\\pskill.exe';
//         $user_data_source = '..\..\..\src\PsKillWrapper\pskill';

    }

}

