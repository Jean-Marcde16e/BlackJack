<?php

require_once("Deck.php");

class Dealer
{
    private Blackjack $blackjack;
    private Deck $deck; 
    private array $players;

    function __construct(Blackjack $blackjack, Deck $deck)
    {
        $this->deck = $deck;
        $this->blackjack = $blackjack;
    }

    public function addPlayer(Player $player) 
    {
        $this->players[] = $player;
    }

    public function getScore(Blackjack $blackjack, $player): string
    {
        return $blackjack->scoreHand($player->hand());
    }

    function dealerAi($activePlayers, $player)
    {
        if ($this->getScore($this->blackjack, $player) >= 18) { // kijk of de dealer met de 1e 2 kaarten boven de 18 zit 
            if ($this->getScore($this->blackjack, $player) != "busted" && !is_numeric($this->getScore($this->blackjack, $player))) {
                return [false, $activePlayers];
            } else {
                echo $player->name() . " stops." . PHP_EOL;
                unset($activePlayers[0]);
                if (count($activePlayers) <= 0) {
                    return [false, $activePlayers];
                }
            }
        } else {
            echo $player->addCard($this->deck->drawCard()); // kijk of de dealer over de 18 zit nadat hij een kaart trekt
            if ($this->getScore($this->blackjack, $player) >= 18) {
                unset($activePlayers[0]);
                if (count($activePlayers) == 0) {
                    return [false, $activePlayers];
                }
            }
        } return [true, $activePlayers];
    }

    function playersPlay($activePlayers, $player)
    {
        $drawing = true;
        while ($drawing == true) {
            $answer = (string)readline($player->name() . "'s turn. " . $player->showHand() . ". 'draw' (d) of 'stop' (s)?... ");
            if ($answer == "s") {
                $drawing = false;
                echo $player->name() . " stops." . PHP_EOL;
                $activePlayers = $this->checkStop($activePlayers, $player);
                if (count($activePlayers) == 0) {
                    return [false, $activePlayers];
                }
            } elseif ($answer == "d") {
                $drawing = false;
                $player->addCard($this->deck->drawCard());
                if ($this->getScore($this->blackjack, $player) != "busted" && !is_numeric($this->getScore($this->blackjack, $player))) {
                    return [false, $activePlayers];
                } elseif ($this->getScore($this->blackjack, $player) > 21) {
                    	$activePlayers = $this->checkStop($activePlayers, $player);
                    if (count($activePlayers) == 0) {
                        return [false, $activePlayers];
                    }
                }
            }
        } return [true, $activePlayers]; 
    }

    function checkStop($activePlayers, $player) 
    {
        foreach ($activePlayers as $currentPlayer) {
            if ($currentPlayer->name() == $player->name()) {
                $keys = array_keys($activePlayers);
                foreach ($keys as $key) {
                    if ($activePlayers[$key]->name() == $currentPlayer->name()) {
                        unset($activePlayers[$key]);
                        return $activePlayers;
                    }
                }
            }
        }
    }

    function endScreen()
    {
        $highscoreWinner = true;
        $highscore = 0;
        $winnerName = "Nobody"; 
        foreach ($this->players as $player) { // win scherm als iedereen is gestopt
            if ($this->getScore($this->blackjack, $player) == "busted") {
                echo $player->name() . " is busted!: " . $player->showHand() . PHP_EOL;
            } 
        }
        foreach ($this->players as $player) {
            if ($this->getScore($this->blackjack, $player) != "busted" && !is_numeric($this->getScore($this->blackjack, $player))) {
                echo $player->name() . " wins! ", $this->getScore($this->blackjack, $player) . "!" . PHP_EOL;
                $highscoreWinner = false;
            }
        }
        if ($highscoreWinner == true) {
            foreach ($this->players as $player) {
                if ($this->getScore($this->blackjack, $player) > $highscore && $this->getScore($this->blackjack, $player) != "busted") {
                    $highscore = $this->getScore($this->blackjack, $player);
                    $winnerName = $player->name();
                }
            }
            echo $winnerName . " wins!" . PHP_EOL;
        }
        foreach ($this->players as $player) {
            if ($this->getScore($this->blackjack, $player) != "busted") {
                echo $player->showHand() . " -> " . $this->getScore($this->blackjack, $player) . PHP_EOL;
            }
        }
    }

    function playGame() 
    {
        $playing = true;

        foreach ($this->players as $player) { // geef iedere speler 2 kaarten en kijk of er blackjack tussen zit
            $player->addCard($this->deck->drawCard());
            $player->addCard($this->deck->drawCard());
            if ($this->getScore($this->blackjack, $player) != "busted" && !is_numeric($this->getScore($this->blackjack, $player))) {
                $playing = false;
            }
        }

        $activePlayers = $this->players;
        while ($playing == true) {
            foreach ($activePlayers as $player) {
                if ($player->name() == "Dealer") { // Dealer AI en checked waardes voor de dealers
                    echo $player->showHand() . PHP_EOL;
                    [$playing, $activePlayers] = $this->dealerAi($activePlayers, $player);
                } else { // speler code
                    if ($playing == true) {
                        [$playing, $activePlayers] = $this->playersPlay($activePlayers, $player);
                    }
                }
            }
        }
        $this->endScreen();
    }
}

?>