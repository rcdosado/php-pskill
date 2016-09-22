<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/22/2016
 * Time: 2:53 PM
 */

namespace PsKillWrapper\Event;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PsKillLoggerListener implements EventSubscriberInterface, LoggerAwareInterface
{    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mapping of event to log level.
     *
     * @var array
     */
    protected $logLevelMappings = array(
        PsKillEvents::PSKILL_PREPARE => LogLevel::INFO,
        PsKillEvents::PSKILL_OUTPUT  => LogLevel::DEBUG,
        PsKillEvents::PSKILL_SUCCESS => LogLevel::INFO,
        PsKillEvents::PSKILL_ERROR   => LogLevel::ERROR,
        PsKillEvents::PSKILL_BYPASS  => LogLevel::INFO,
    );

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->setLogger($logger);
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Sets the log level mapping for an event.
     *
     * @param string $eventName
     * @param string|false $logLevel
     *
     * @return \PsKillWrapper\Event\PsKillLoggerListener
     */
    public function setLogLevelMapping($eventName, $logLevel)
    {
        $this->logLevelMappings[$eventName] = $logLevel;
        return $this;
    }

    /**
     * Returns the log level mapping for an event.
     *
     * @param string $eventName
     *
     * @return string
     *
     * @throws \DomainException
     */
    public function getLogLevelMapping($eventName)
    {
        if (!isset($this->logLevelMappings[$eventName])) {
            throw new \DomainException('Unknown event: ' . $eventName);
        }

        return $this->logLevelMappings[$eventName];
    }
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            PsKillEvents::PSKILL_PREPARE => array('onPrepare', 0),
            PsKillEvents::PSKILL_OUTPUT  => array('handleOutput', 0),
            PsKillEvents::PSKILL_SUCCESS => array('onSuccess', 0),
            PsKillEvents::PSKILL_ERROR   => array('onError', 0),
            PsKillEvents::PSKILL_BYPASS  => array('onBypass', 0),
        );
    }

    /**
     * Adds a log message using the level defined in the mappings.
     *
     * @param \PsKillWrapper\Event\PsKillEvent $event
     * @param string $message
     * @param array $context
     * @param string $eventName
     *
     * @throws \DomainException
     */
    public function log(PsKillEvent $event, $message, array $context = array(), $eventName = NULL)
    {
        // Provide backwards compatibility with Symfony 2.
        if (empty($eventName) && method_exists($event, 'getName')) {
            $eventName = $event->getName();
        }
        $method = $this->getLogLevelMapping($eventName);
        if ($method !== false) {
            $context += array('command' => $event->getProcess()->getCommandLine());
            $this->logger->$method($message, $context);
        }
    }
    public function onPrepare(PsKillEvent $event, $eventName = NULL)
    {
        $this->log($event, 'PsKill command preparing to run', array(), $eventName);
    }

    public function handleOutput(PsKillOutputEvent $event, $eventName = NULL)
    {
        $context = array('error' => $event->isError() ? true : false);
        $this->log($event, $event->getBuffer(), $context, $eventName);
    }

    public function onSuccess(PsKillEvent $event, $eventName = NULL)
    {
        $this->log($event, 'PsKill command successfully run', array(), $eventName);
    }

    public function onError(PsKillEvent $event, $eventName = NULL)
    {
        $this->log($event, 'Error running PsKill command', array(), $eventName);
    }

    public function onBypass(PsKillEvent $event, $eventName = NULL)
    {
        $this->log($event, 'PsKill command bypassed', array(), $eventName);
    }
}