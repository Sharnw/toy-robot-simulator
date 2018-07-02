<?php

require_once('Simulation/Exceptions/MoveException.php');
require_once('Simulation/Exceptions/InputException.php');
require_once('Simulation/Board.php');
require_once('Simulation/Robot.php');
require_once('Simulation/MoveProcessor.php');

use Simulation\Board;
use Simulation\Robot;
use Simulation\MoveProcessor;

use Simulation\Exceptions\InputException;

// board is always the same and does not change state, so we only need 1 instance
$board = new Board(5, 5);

echo "scanning for input files\r\n";
$files = glob('inputs/*.txt', GLOB_BRACE);
echo count($files)." found\r\n\r\n";
foreach($files as $file) {
	echo "processing {$file}\r\n";
	$contents = file_get_contents($file);
	$lines = explode("\n", $contents);
	if (count($lines) == 0) {
		echo "skipping\r\n";
	}
	else {
		$robot = new Robot();
		$mover = new MoveProcessor($board, $robot);
		foreach ($lines as $text) {
			if (trim($text) == '') continue;
			$mover->processCommand($text);
		}
		echo "\r\n";
	}	
}
