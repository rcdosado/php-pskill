<?php

$strs = <<<EOT
PsKill v2.15 - Terminates processes on local or remote systems
Copyright (C) 1999-2012  Mark Russinovich
Sysinternals - www.sysinternals.com

Usage: pskill [-t] [\\computer [-u username [-p password]]] <process ID | name>
     -t    Kill the process and its descendants.
     -u    Specifies optional user name for login to
           remote computer.
     -p    Specifies optional password for user name. If you omit this
           you will be prompted to enter a hidden password.
EOT;

preg_match('/^PsKill\sv[1-9]\.[0-9][0-9]/', $strs, $m);
print_r($m);