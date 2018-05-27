<?php


namespace TicTacToe\Domain\Game\Entity;

use Assertion\Assertion;
use TicTacToe\Domain\Entity\BaseEntity;
use TicTacToe\Domain\Entity\ValueObject\Identity;
use TicTacToe\Domain\Game\MoveMade\Entity\MoveMade;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\Game\MoveMade\Entity\ValueObject\MoveMadeIdentity;
use TicTacToe\Domain\Move\ValueObject\Move;
use TicTacToe\Domain\Move\ValueObject\MoveParameters;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\WinCondition\ValueObject\WinCondition;

class Game extends BaseEntity
{
    /** @var User[] */
    private $users;
    /** @var GameState */
    private $gameState;
    /** @var WinCondition[] */
    private $winConditions;
    /** @var MoveMade[] */
    private $movesMade;
    private $winner;

    public function __construct(
        Identity $identity,
        array $users,
        GameState $initialState,
        array $winConditions
    ) {
        parent::__construct($identity);
        $this->setUsers($users);
        $this->setGameState($initialState);
        $this->setWinConditions($winConditions);
        $this->movesMade = [];
        $this->winner = $this->checkWinConditions();
    }

    public function make(User $user, Move $move, MoveParameters $moveParameters)
    {
        Assertion::null($this->winner, "Cannot make moves on finished game");
        Assertion::inArray($user, $this->users);
        $move->make($user, $this->gameState, $moveParameters);
        $this->addMoveMade(
            new MoveMade(
                new MoveMadeIdentity(),
                $this,
                $user,
                $move,
                $moveParameters
            )
        );
    }

    public function checkWinConditions(): ?User
    {
        if (!is_null($this->winner)) {
            return $this->winner;
        }
        $winConditionReturns = [];
        foreach($this->winConditions as $winCondition) {
            $winConditionReturns []= $winCondition->check($this->gameState);
        }
        try {
            Assertion::allIsInstanceOf($winConditionReturns, User::class);
            Assertion::allSame(...$winConditionReturns);
        } catch (\InvalidArgumentException $e) {
            $winState = null;
        }
        $winState = array_pop($winConditionReturns);

        return $winState;
    }

    private function addMoveMade(MoveMade $moveMade)
    {
        $this->movesMade []= $moveMade;
    }

    /**
     * @return MoveMade[]
     */
    public function getMovesMade(): array
    {
        return $this->movesMade;
    }

    private function setUsers(array $users)
    {
        Assertion::notEmpty($users);
        Assertion::allIsInstanceOf($users, User::class);
        $this->users = $users;
    }

    private function setGameState(GameState $gameState)
    {
        $this->gameState = $gameState;
    }

    private function setWinConditions(array $winConditions)
    {
        Assertion::allIsInstanceOf($winConditions, WinCondition::class);
        $this->winConditions = $winConditions;
    }
}
