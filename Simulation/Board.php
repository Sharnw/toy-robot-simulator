<?php

namespace Simulation;

use Simulation\Exceptions\InputException;

/*
* All the Board class needs to do is store it's dimensions
* and check whether a specified move position (x, y) will be 
* valid and within those dimensions.
*/
class Board {

	/*
	* @param $height Int The board height.
	* @param $width  Int The board width.
	*/
	public function __construct(Int $height, Int $width) {
		if ($height == 0 or $width == 0) throw new InputException('Invalid height/width for specified for board.');
		$this->xMin = 0;
		$this->yMin = 0;
		$this->xMax = $height-1;
		$this->yMax = $width-1;
	}

	/*
	* Check whether a given position is valid and within the boards dimensions
	*
	* @param $x Int The x position of proposed move.
	* @param $y Int The y position of proposed move.
	*
	* @return Boolean 
	*/
	public function isMoveValid(Int $x, Int $y) {
		$xInvalid = ($x < $this->xMin or $x > $this->xMax);
		$yInvalid = ($y < $this->yMin or $y > $this->yMax);
		return (!$xInvalid and !$yInvalid);
	}

}