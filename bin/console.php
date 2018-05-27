#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new \TicTacToe\Infrastructure\Presentation\Console\CreateUserCommand());
$application->add(new \TicTacToe\Infrastructure\Presentation\Console\DeleteUserCommand());
$application->add(new \TicTacToe\Infrastructure\Presentation\Console\CreateGameBetweenTwoUsersCommand());
$application->add(new \TicTacToe\Infrastructure\Presentation\Console\UserMakesMoveOnGameCommand());
$application->add(new \TicTacToe\Infrastructure\Presentation\Console\CheckGameWinnerCommand());

$application->run();
