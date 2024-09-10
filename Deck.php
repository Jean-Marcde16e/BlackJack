<?php

require_once("Card.php");

class Deck
{
    private array $cards = [];
    function __construct()
    {
        foreach (Card::SUITS as $symbol) {
            foreach (Card::VALUES as $value) {
                array_push($this->cards, new Card($symbol, $value));
            }
        }
        shuffle($this->cards);
    }

    public function drawCard(): Card
    {
        if (count($this->cards) <= 0) {
            throw new Exception("Het deck is leeg");
        } else {
            $onecard = array_shift($this->cards);
        }
        return $onecard;
    }
}


?>