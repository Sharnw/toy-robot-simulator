<?php

namespace Simulation;

use Simulation\Exceptions\MoveException;
use Simulation\Exceptions\InputException;

/*
* Because there is only one object on the board we can store the board 
* as an attribute of the robot.
*/
class Robot {

	protected $board, $x, $y, $f;

	/*
	* Run 'PLACE' command.
	*
	* Places robot on specified board and validates/sets initial x/y/f values
	*
	* @param $board Board The board to place this robot on.
	* @param $x 	Int    The x position to place robot.
	* @param $y 	Int    The y position to place robot.
	* @param $f 	Int    The f/rotation angle the robot should face.
	*/
	public function placeOnBoard(Board $board, Int $x, Int $y, Int $f) {
		$this->validateRotation($f);

		if (!$board->isMoveValid($x, $y)) {
			throw new MoveException('Invalid robot position specified.');
		}
		else {
			$this->board = $board;
			$this->x = $x;
			$this->y = $y;
			$this->f = $f;
		}
	}

	// COMMANDS

	/*
	* Run 'RIGHT' command
	*
	* Rotates robots f angle 90 degrees to the right
	*/
	public function faceLeft() {
		$this->validateBoard();

		// no need to validate rotation again as there is no input
		if ($this->f >= 90) $this->f -= 90;
		else $this->f = 270;
	}

	/*
	* Run 'LEFT' command
	*
	* Rotates robots f angle 90 degrees to the left
	*/
	public function faceRight() {
		$this->validateBoard();

		// no need to validate rotation again as there is no input
		if ($this->f == 270) $this->f = 0;
		else $this->f += 90;
	}

	/*
	* Run 'MOVE' command
	* Moves the robot forwards one square if move is valid
	*/
	public function moveForward() {
		$this->validateBoard();

		$newX = $this->x;
		$newY = $this->y;
		switch ($this->f) {
			case 0:
				$newY += 1;
			break;
			case 90:
				$newX += 1;
			break;
			case 180:
				$newY -= 1;
			break;
			case 270:
				$newX -= 1;
			break;
			default:
				throw InputException('Invalid rotation has resulted in impossible move.'); // shouldn't be necessary
		}

		if (!$this->board->isMoveValid($newX, $newY)) {
			throw new MoveException('Cannot move forward as current rotation will lead to falling.');
		}
		else {
			$this->x = $newX;
			$this->y = $newY;
		}
	}

	/*
	* Run 'REPORT' command
	*
	* Announces the X, Y, and F of the robot
	*/
	public function report() {
		echo "x: {$this->x}, y: {$this->y}, f: {$this->getFacing()}\r\n";
	}

	// VALIDATORS

	/*
	* Validates a new f/rotation value to ensure it is divisable by 90
	*
	* @param $rotation Int The rotation angle to validate.
	*/
	private function validateRotation(Int $rotation) {
		if ($rotation % 90 != 0) throw new InputException('Robot angle (f) must be divisable by 90 degrees');
	}

	/*
	* Validates whether the robot has been placed on a valid board.
	*/
	private function validateBoard() {
		if (!$this->board) throw new MoveException('Cannot move before being placed on a board');
	}

	// DYNAMIC ATTRIBUTES

	/*
	* Get pretty text version of f/rotation
	*/
	private function getFacing() {
		switch ($this->f) {
			case 0:
				return 'NORTH';
			break;
			case 90:
				return 'EAST';
			break;
			case 180:
				return 'SOUTH';
			break;
			case 270:
				return 'WEST';
			break;
		}
	}

}