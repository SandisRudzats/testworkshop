<?php


use PF\BowlingGame;

class BowlingTest extends \PHPUnit\Framework\TestCase
{
    public function testGetScore_withAllZeros_getScoreZero()
    {
        //set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        //test
        $score = $game->getScore();


        //assert
        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_getsScore20()
    {
        //set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        //test
        $score = $game->getScore();


        //assert
        self::assertEquals(20, $score);
    }

    public function testGetScore_withSpare_getScoreWithSpareBonus()
    {
        //set up
        $game = new BowlingGame();

        $game->roll(2);
        $game->roll(8);
        $game->roll(5);


        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        //test
        $score = $game->getScore();


        //assert
        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_getScoreWithStrikeBonus()
    {
        //set up
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(3);
        $game->roll(5);


        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        //test
        $score = $game->getScore();


        //assert
        self::assertEquals(42, $score);
    }

    public function testGetScore_withAComplicatedGame_getsCorrectScore()
    {
        //set up
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(3);
        $game->roll(5);

        $game->roll(10);

        $game->roll(10);

        $game->roll(4);

        $game->roll(4);


        for ($i = 0; $i < 10; $i++) {
            $game->roll(1);
        }

        //test
        $score = $game->getScore();


        //assert
        self::assertEquals(86, $score);
    }

    public function testGetScore_withAPerfectGame_getScore300()
    {
        //set up
        $game = new BowlingGame();

        $game->roll(10);

        for ($i = 0; $i <= 10; $i++) {
            $game->roll(10);
        }

        //test
        $score = $game->getScore();


        //assert
        self::assertEquals(300, $score);
    }

    public function testGetScore_withMinusOnePin_GetInvalidArgumentException()
    {
        $game = new BowlingGame();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Are you trying to resurrect a pin?');

        for ($i = 0; $i <= 10; $i++) {
            $game->roll(-1);
        }


        $game->getScore();
    }

    public function testGetScore_withElevenPins_GetInvalidArgumentException()
    {
        $game = new BowlingGame();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Its impossible to mow down 11 pins , when there are only 10?');

        for ($i = 0; $i <= 10; $i++) {
            $game->roll(11);
        }

        $game->getScore();
    }

    public function testGetScore_WithFiveThrows_getInvalidArgumentException(): void
    {
        $game = new BowlingGame();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not enough rolls have been made');

        for ($i = 0; $i < 5; $i++) {
            $game->roll(1);
        }

        $game->getScore();
    }

    public function testGetScore_WithTwentyFiveThrows_getInvalidArgumentException(): void
    {
        $game = new BowlingGame();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Too many rolls!');

        for ($i = 0; $i < 25; $i++) {
            $game->roll(1);
        }

        $game->getScore();
    }
}