<?php

namespace Simulation;

use Simulation\Exceptions\InputException;

/*
* Processes move text from input files and actions them on a robot.
*/
class MoveProcessor {

	private $board, $robot;

	/*
	* Construct uses references for board/robot so we can see the changes 
	* from outside of this class.
	*
	* @param $board Board The board object to be used in place command.
	* @param $robot Robot The robot object to action commands on.
	*/
	public function __construct(Board &$board, Robot &$robot) {
		$this->board = $board;
		$this->robot = $robot;
	}

	/*
	* Attempts to action a command on robot from input text
	*
	* @param $string String An individual line of text from input file
	*/
	public function processCommand(String $text) {
		$commandParts = explode(' ', $text);
		$command = trim($commandParts[0]);
		if ($command == 'PLACE' AND isset($commandParts[1])) {
			echo "attempting PLACE command\r\n";
			$placeParams = explode(',', trim($commandParts[1]));
			if (count($placeParams) != 3) {
				throw new InputException("Invalid 'PLACE' parameters specified.");
			}
			else {
				$this->robot->placeOnBoard($this->board, (int) $placeParams[0], (int) $placeParams[1], $this->getDirectionDegrees($placeParams[2]));
			}
		}
		else {
			echo "attempting {$command} command\r\n";
			switch ($command) {
				case 'LEFT':
					$this->robot->faceLeft();
				break;
				case 'RIGHT':
					$this->robot->faceRight();
				break;
				case 'MOVE':
					$this->robot->moveForward();
				break;
				case 'REPORT':
					$this->robot->report();
				break;
			}
		}
	}

	private function getDirectionDegrees($direction) {
		switch ($direction) {
			case 'NORTH':
				return 0;
			case 'EAST':
				return 90;
			case 'SOUTH':
				return 180;
			case 'WEST':
				return 270;	
		}
		throw new InputException("Invalid 'PLACE' direction specified.");
	}

}