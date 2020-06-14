<?php


namespace PF;


use InvalidArgumentException;
use PHPUnit\Framework\Exception;

class BowlingGame
{
    private array $rolls = [];

    public function roll(int $score): void
    {
        $this->rolls[] += $score;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            $this->checkIfMinNumberOfRollsHaveBeenMade($roll);

            if ($this->isInvalidRoll($roll)) {
                throw new InvalidArgumentException('Are you trying to resurrect a pin?');
            }

            if ($this->isMaxPinLimitReached($roll)) {
                throw new InvalidArgumentException('Its impossible to mow down 11 pins , when there are only 10?');
            }

            if ($this->isStrike($roll)) {
                $score += 10 + $this->getStrikeBonus($roll);
                $roll++;
                continue;
            }

            if ($this->isSpare($roll)) { //is a spare
                $score += $this->getSpareBonus($roll);
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }
        $this->checkIfTooManyRollsHaveBeenMade($roll);

        return $score;
    }

    /**
     * @param int $roll
     * @return mixed
     */
    public function getNormalScore(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isSpare(int $roll): bool
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param int $roll
     * @return mixed
     */
    public function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return mixed
     */
    public function getStrikeBonus(int $roll): int
    {
        return $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }

    private function isInvalidRoll(int $roll)
    {
        return $this->rolls[$roll] === -1;
    }

    private function isMaxPinLimitReached(int $roll)
    {
        return $this->rolls[$roll] === 11;
    }

    private function checkIfMinNumberOfRollsHaveBeenMade(int $roll)
    {
        $minimumRollCount = 11;
        $rollsCount = count($this->rolls);
        if ($rollsCount < $minimumRollCount) {
            throw new InvalidArgumentException('Not enough rolls have been made');
        }
    }

    private function checkIfTooManyRollsHaveBeenMade(int $roll)
    {
        $maximumRollCount = 20;
        $rollsCount = count($this->rolls);
        if ($rollsCount > $maximumRollCount) {
            throw new InvalidArgumentException('Too many rolls!');
        }
    }
}