## Table of Contents

* [🚀Environment setup](#-environment-setup)
  * [🐳Needed tools](#-needed-tools)
  * [🛠️Environment configuration](#-environment-configuration)
  * [🌍Application execution](#-application-execution)
  * [Tests execution](#-tests-execution)
  
## Environment setup

### Needed tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/marydn/shogi`
3. Move to the project folder: `cd shogi`
4. Install PHP dependencies and bring up the project Docker containers with Docker Compose: `make build`
5. Check everything's up using: `$ docker-composer ps`. It should show `php` service up.

### Application execution

Start game using: `make play`

### Tests execution

Execute PHP Unit tests: `make test`

## Project explanation

OOP Design example for a variation of a Japanese chess version called Shogi.

Developed features:
    - Console interactive interface
    - Pieces placement
    - Pieces movements
    - Pieces captures
    
```bash
$ tree -L 4 src
src
├── Board.php
├── CliPrintableSpot.php // Decorator for console output
├── Command
│   └── GameCommand.php // Console output application
├── CoordinateTranslator.php // Translate user's input to a valid coordinate to handle internally
├── Exception
│   ├── CoordinateNotFound.php
│   ├── CoordinateNotWellFormedNotation.php
│   └── IllegalMove.php
├── Game.php
├── Move.php
├── MovesList.php // Collection of Moves
├── Notation.php // Every move is saved as a Notation object
├── Pieces // Every piece in the Board
│   ├── BasePiece.php
│   ├── Bishop.php
│   ├── GoldGeneral.php
│   ├── King.php
│   ├── Knight.php
│   ├── Lance.php
│   ├── Pawn.php
│   ├── PieceInterface.php
│   ├── PiecePromotableInterface.php
│   ├── Rook.php
│   └── SilverGeneral.php
├── PlayerInventory.php // Player's inventory
├── Player.php // Every player of the game
├── Shared
│   └── Collection.php // Abstract class for Objects that holds collections
├── Spot.php   // Every spot in the Board
└── ValueObject
    └── Coordinate.php  // User's input
```