<?php

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ExecutableFinder;

$loc = __DIR__.'\\pskill.exe';

if( file_exists($loc))
{
	echo 'PSKILL Exists --> ';
	echo 'here it is '.$loc;
}
else
	echo 'PSKILL Not exists';


$finder = new \Symfony\Component\Process\ExecutableFinder();

$splitBinary = $finder->find('pskill');
echo $splitBinary;

if (!$splitBinary) {
    echo 'Unable to find the split executable.';
}