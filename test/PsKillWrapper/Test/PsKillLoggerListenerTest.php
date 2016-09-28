<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/22/2016
 * Time: 3:07 PM
 */

namespace PsKillWrapper\Test;


use PsKillWrapper\Event\PsKillLoggerListener;
use PsKillWrapper\PsKillCommand;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

include_once('PsKillWrapperTestCase.php');
include_once('TestLogger.php');
class PsKillLoggerListenerTest extends PsKillWrapperTestCase {

    public function testGetLogger(){
        $log = new NullLogger();
        $listener = new PsKillLoggerListener($log);
        $this->assertEquals($log, $listener->getLogger());
    }
    public function testSetLogLevelMapping()
    {
        $listener = new PsKillLoggerListener(new NullLogger());
        $listener->setLogLevelMapping('test.event', 'test-level');
        $this->assertEquals('test-level', $listener->getLogLevelMapping('test.event'));
    }

    /**
     * @expectedException \DomainException
     */
    public function testGetInvalidLogLevelMapping()
    {
        $listener = new PsKillLoggerListener(new NullLogger());
        $listener->getLogLevelMapping('bad.event');
    }

    public function testRegisterLogger()
    {
        $logger = new TestLogger();
        $this->wrapper->addLoggerListener(new PsKillLoggerListener($logger));
        echo $this->wrapper->version()[0];
//        $git = $this->wrapper->init(self::REPO_DIR, array('bare' => true));

        echo "instead its ".$logger->messages[1];
//        $this->assertEquals('PsKill command preparing to run', $logger->messages[1]);
//        $this->assertEquals('Initialized empty PsKill repository in ' . realpath(self::REPO_DIR) . "/\n", $logger->messages[1]);
//        $this->assertEquals('PsKill command successfully run', $logger->messages[2]);
//
//        $this->assertArrayHasKey('command', $logger->contexts[0]);
//        $this->assertArrayHasKey('command', $logger->contexts[1]);
//        $this->assertArrayHasKey('error', $logger->contexts[1]);
//        $this->assertArrayHasKey('command', $logger->contexts[2]);
//
//        $this->assertEquals(LogLevel::INFO, $logger->levels[0]);
//        $this->assertEquals(LogLevel::DEBUG, $logger->levels[1]);
//        $this->assertEquals(LogLevel::INFO, $logger->levels[2]);
//
//        try {
//            $logger->clearMessages();
//            $git->commit('fatal: This operation must be run in a work tree');
//        } catch (\Exception $e) {
//            // Nothing to do, this is expected.
//        }
//
//        $this->assertEquals('Error running PsKill command', $logger->messages[2]);
//        $this->assertArrayHasKey('command', $logger->contexts[2]);
//        $this->assertEquals(LogLevel::ERROR, $logger->levels[2]);
    }

}