### Toy Robot Simulator

## Instructions

To execute the simulation please run the following command from repo directory in your command-line:

``php run_simulations.php``

## Notes & Assumptions

* Only one object can be placed on the board at a time, hence why the board is attached to the robot and not the other way around
* Assuming the input text is going to be fairly accurate, otherwise the amount of text validation when processing each command may not be adequate
* Were these classes to be implemented in further projects they might want to catch specific exception types 'MoveException' & 'InputException'