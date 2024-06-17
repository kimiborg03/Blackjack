<?php

require_once 'Blackjack.php';
require_once 'Deck.php';
require_once 'Player.php';

class Dealer
{
    private Blackjack $blackjack;
    private Deck $deck;
    private array $players = [];
    private ?int $highestScore = null;

    public function __construct(Blackjack $blackjack, Deck $deck)
    {
        $this->blackjack = $blackjack;
        $this->deck = $deck;
    }
//Voegt een speler toe
    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }
//start het spel
    public function playGame()
    {
        $this->addPlayer(new Player('Dealer'));
        $this->deck->shuffle();
        foreach ($this->players as $player) {
            $this->dealInitialHand($player);
        }
        $this->checkBlackjack();

        foreach ($this->players as $player) {
            echo PHP_EOL . "{$player->getName()}'s turn." . PHP_EOL;
            $this->playTurn($player);
        }

        $this->checkWinners();
    }

//kijkt of er blackjack is
    private function checkBlackjack()
    {
        $blackjackWinners = [];
        foreach ($this->players as $player) {
            $score = $this->blackjack->scoreHand($player->getHand());
            if ($score === 'Blackjack') {
                $blackjackWinners[] = $player;
            }
        }

        if (!empty($blackjackWinners)) {
            foreach ($blackjackWinners as $winner) {
                echo "{$winner->getName()} wins! Blackjack" . PHP_EOL;
            }
            exit;
        }
    }
//Checkt of iemand heeft gewonnen
    private function checkWinners()
    {
        $twentyOneWinners = [];
        $fiveCardCharlieWinners = [];

        foreach ($this->players as $player) {
            $score = $this->blackjack->scoreHand($player->getHand());
            if ($score === 'Twenty-One') {
                $twentyOneWinners[] = $player;
            } elseif ($score === 'Five Card Charlie') {
                $fiveCardCharlieWinners[] = $player;
            }
        }
//bij een twenty-one
        if (!empty($twentyOneWinners)) {
            foreach ($twentyOneWinners as $winner) {
                echo "The winner is {$winner->getName()} with Twenty-One" . PHP_EOL;
            }
        }
//bij een five card charlie
        if (!empty($fiveCardCharlieWinners)) {
            foreach ($fiveCardCharlieWinners as $winner) {
                echo "The winner is {$winner->getName()} with Five Card Charlie" . PHP_EOL;
            }
        }

        $highestScoreWinners = [];
        $highestScore = 0;
//winnaar bij hoogste score
        foreach ($this->players as $player) {
            $score = $this->blackjack->scoreHand($player->getHand());

            if ($score !== 'Busted' && $score > $highestScore) {
                $highestScore = $score;
                $highestScoreWinners = [$player];
            } elseif ($score === $highestScore) {
                $highestScoreWinners[] = $player;
            }
        }

        if (count($highestScoreWinners) === 1) {
            $winner = reset($highestScoreWinners);
            echo "The winner is {$winner->getName()} with {$this->blackjack->scoreHand($winner->getHand())}" . PHP_EOL;
        } elseif (count($highestScoreWinners) > 1) {
            echo "It's a tie between: ";
            foreach ($highestScoreWinners as $winner) {
                echo "{$winner->getName()} ";
            }
            echo PHP_EOL;
        }
    }
//beurt van het spel
    private function playTurn(Player $participant)
    {
        while (true) {
            $hand = $participant->getHand();
            $handString = $participant->showHand();
            $score = $this->blackjack->scoreHand($hand);

            echo "$handString -> $score" . PHP_EOL;
            if ($score === "Busted") {
                echo "{$participant->getName()} is Busted!" . PHP_EOL;
                break;
            }

            if (in_array($score, ['Blackjack', 'Twenty-One', 'Five Card Charlie', 21])) {
                break;
            }

            if ($participant->getName() === 'Dealer') {
                if ($score <= 16) {
                    $newCard = $this->deck->drawCard();
                    echo "{$participant->getName()} drew {$newCard->show()}" .  PHP_EOL;
                    $hand[] = $newCard;
                    $participant->setHand($hand);
                } else {
                    $this->stopPlayer($participant, $score);
                    break;
                }
            } else {
                $response = strtolower(readline("'draw' (d) or 'stop' (s)? "));

                if ($response === 'd') {
                    $newCard = $this->deck->drawCard();
                    echo "{$participant->getName()} drew {$newCard->show()}" .  PHP_EOL;
                    $hand[] = $newCard;
                    $participant->setHand($hand);
                } elseif ($response === 's') {
                    $this->stopPlayer($participant, $score);
                    break;
                } else {
                    echo "Invalid input. Please enter 'd' for draw or 's' for stop." . PHP_EOL;
                }
            }
        }
    }
//geeft 2 kaarten aan het begin van het spel
    private function dealInitialHand(Player $player)
    {
        $hand = [$this->deck->drawCard(), $this->deck->drawCard()];
        $player->setHand($hand);
        $score = $this->blackjack->scoreHand($player->getHand());
        echo "{$player->showHand()} -> $score" . PHP_EOL;
    }
//stopt de speler zijn beurt
    private function stopPlayer(Player $player, $score)
    {
        if ($score <= 21 && ($this->highestScore === null || $score > $this->highestScore)) {
            $this->highestScore = $score;
        }
        echo "{$player->getName()} stops." . PHP_EOL;
    }
}