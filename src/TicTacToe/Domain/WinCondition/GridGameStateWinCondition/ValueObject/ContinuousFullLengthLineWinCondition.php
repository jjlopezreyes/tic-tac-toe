<?php


namespace TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject;

use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\User\Entity\User;

class ContinuousFullLengthLineWinCondition extends GridGameStateWinCondition
{
    /**
     * @param GridGameState $gameState
     * @return null|User
     */
    public function check(
        GameState $gameState
    ): ?User {
        parent::check($gameState);
        $size = $gameState->size();
        $markRows = $gameState->markRows();

        $user = $this->checkRows($size, $markRows);
        if(!empty($user)) {
            return $user;
        }

        $user = $this->checkColumns($size, $markRows);
        if(!empty($user)) {
            return $user;
        }

        //check LR diagonal
        $user = $this->checkLeftDiagonal($markRows, $size);
        if(!empty($user)) {
            return $user;
        }

        //check RL diagonal
        return $this->checkRightDiagonal($markRows, $size);
    }

    /**
     * @param $size
     * @param $markRows
     * @return null|User
     */
    private function checkRows($size, $markRows): ?User
    {
        for ($i = 0; $i < $size; $i++) {
            $user = $markRows[$i][0];
            $mark = null;
            if (!($user instanceof User)) {
                continue;
            }
            for ($j = 0; $j < $size; $j++) {
                $mark = $markRows[$i][$j];
                if (!($mark instanceof User)
                    || $mark !== $user) {
                    break;
                }
            }
            if ($user === $mark) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param $size
     * @param $markRows
     * @return null|User
     */
    private function checkColumns($size, $markRows): ?User
    {
        for ($i = 0; $i < $size; $i++) {
            $user = $markRows[0][$i];
            $mark = null;
            if (!($user instanceof User)) {
                continue;
            }
            for ($j = 0; $j < $size; $j++) {
                $mark = $markRows[$j][$i];
                if (!($mark instanceof User)
                    || $mark !== $user) {
                    break;
                }
            }
            if ($user === $mark) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param $markRows
     * @param $size
     * @return null|User
     */
    private function checkLeftDiagonal($markRows, $size): ?User
    {
        $user = empty($markRows[0][0]) ? null : $markRows[0][0];
        $mark = null;
        if ($user instanceof User) {
            for ($i = 0; $i < $size; $i++) {
                $mark = $markRows[$i][$i];
                if (!($mark instanceof User)
                    || $mark !== $user) {
                    break;
                }
            }
            if ($user === $mark) {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param $markRows
     * @param $size
     * @return null|User
     */
    private function checkRightDiagonal($markRows, $size): ?User
    {
        $user = empty($markRows[0][$size - 1]) ? null : $markRows[0][$size - 1];
        $mark = null;
        if ($user instanceof User) {
            for ($i = 0; $i < $size; $i++) {
                $mark = $markRows[$i][$size - 1 - $i];
                if (!($mark instanceof User)
                    || $mark !== $user) {
                    break;
                }
            }
            if ($user === $mark) {
                return $user;
            }
        }

        return null;
    }
}
