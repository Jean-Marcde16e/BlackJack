<?php

require_once("Blackjack.php");

class Player
{
    private string $name;
    private array $hand = [];

    function __construct($name)
    {
        $this->name = $name;
    }

    public function addCard(Card $card)
    {
        $this->hand[] = $card;
        if (count($this->hand) >= 3) {
            echo $this->name . " drew " . $card->show() . PHP_EOL;
        }
    }

    public function showHand(): string 
    {
        $cardString = "";
        foreach ($this->hand as $handcard) {
            $cardString .=  " " . $handcard->show();
        }
        return $this->name . " has" . $cardString;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hand(): array
    {
        return $this->hand;
    }
}



?>