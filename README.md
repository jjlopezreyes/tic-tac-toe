# tic-tac-toe
PHP implementation of an any-board-size Tic-Tac-Toe game.

As with the traditional 3x3 Tic-Tac-Toe, the objective is to fill an entire row, column or corner diagonal with marks all belonging to the same player.

## Usage
### Requirements
PHP 7.2 or any version backwards compatible with it.

### Setup
Simply run composer install from the root folder.

### CLI Interface
From the root of the project, run:
'''php bin/console "commandname" "args1" "arg2"...'''

As the repositories are currently implemented to store data in the PHP process memory,
you will be unable to play a full game using the CLI.
If you wish to test different game scenarios, modify the Commands so that the repositories they use are pre-configured with data.

You can find examples under tests/Component.

### Running Tests
From the root of the project, run bin/phpunit
