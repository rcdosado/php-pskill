<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/17/2016
 * Time: 8:44 AM
 */

namespace PsKillWrapper\Test;

use PsKillWrapper\PsKillCommand;

include_once("PsKillWrapperTestCase.php");

class PsKillCommandTest extends PsKillWrapperTestCase
{

    public function testCommand(){
        $command = $this->randomString();
        $argument = $this->randomString();
        $flag = $this->randomString();
        $optionName = $this->randomString();
        $optionValue = $this->randomString();

        $pskill = PsKillCommand::getInstance($command)
            ->addArgument($argument)
            ->setFlag($flag)
            ->setOption($optionName, $optionValue);

        $expected = "$command --$flag --$optionName=\"$optionValue\" \"$argument\"";
        $commandLine = $pskill->getCommandLine();

        $this->assertEquals($expected, $commandLine);
//        $this->assertEquals(1, 1);
    }

    public function testOption()
    {
        $optionName = $this->randomString();
        $optionValue = $this->randomString();

        $pskill = PsKillCommand::getInstance()
            ->setOption($optionName, $optionValue);

        $this->assertEquals($optionValue, $pskill->getOption($optionName));

        $pskill->unsetOption($optionName);
        $this->assertNull($pskill->getOption($optionName));
    }

    /**
     *
     */
    public function testMultiOption()
    {
        $pskill = PsKillCommand::getInstance('test-command')
            ->setOption('test-arg', array(true, true));

        $expected = 'test-command --test-arg --test-arg';
        $commandLine = $pskill->getCommandLine();

        $this->assertEquals($expected, $commandLine);
    }
} 