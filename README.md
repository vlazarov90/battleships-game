# battleships-game

Instructions:
1. do not use a framework
2. use an autoloader
3. do not use a database
4. do not store console state on filesystem. console should run continuously until game over. Do not do  php index.php A1

Game specifications:
Programming Test: Battle ships 
The purpose of this test is primarily to examine your problem solving skills.

Please follow this spec carefully!

You must write the game as a simple application with web and console user interfaces using shared game logic in the language requested. In the case of PHP developer should create a index.php file which loads (requires) the appropriate controller and logic.

In addition to working code that follows this spec you are expected to make your code elegant / beautiful and the best you can do, i.e. separation of logic / object oriented abstraction. Comment your code as necessary.
The Problem
Implement a simple game of battleships http://en.wikipedia.org/wiki/Battleship_(game)

You must create a simple application to allow a single human player to play a one-sided game of battleships against the computer.

The program should create a 10x10 grid, and place a number of ships on the grid at random with the following sizes:
1 x Battleship (5 squares)
2 x Destroyers (4 squares)
Ships can touch but they must not overlap.

The application should accept input from the user in the format “A5” to signify a square to target, and feedback to the user whether the shot was success, miss, and additionally report on the sinking of any vessels.
. = no shot
- = miss
X = hit
