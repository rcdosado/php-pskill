<?php
/**
 * Created by PhpStorm.
 * User: m1k3y
 * Date: 9/17/2016
 * Time: 12:13 AM
 */

namespace PsKillWrapper\Event;


final class PsKillEvents {

  /**
     * Event thrown prior to executing a pskill.command.
     *
     * @var string
     */
    const PSKILL_PREPARE = 'pskill.command.prepare';

    /**
     * Event thrown when real-time output is returned from the Git command.
     *
     * @var string
     */
    const PSKILL_OUTPUT = 'pskill.command.output';

    /**
     * Event thrown after executing a succesful pskill command.
     *
     * @var string
     */
    const PSKILL_SUCCESS = 'pskill.command.success';

    /**
     * Event thrown after executing a unsuccesful pskill command.
     *
     * @var string
     */
    const PSKILL_ERROR = 'pskill.command.error';

    /**
     * Event thrown if the command is flagged to skip execution.
     *
     * @var string
     */
    const PSKILL_BYPASS = 'pskill.command.bypass';

    /**
     * Deprecated in favor of GitEvents::PSKILL_PREPARE.
     *
     * @var string
     *
     * @deprecated since version 1.0.0beta5
     */
    const PSKILL_COMMAND = 'pskill.command.prepare';

} 