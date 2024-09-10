<?php

require_once("Card.php");
require_once("Player.php");

class Blackjack
{
    public function scoreHand(array $hand): string
    {
        $score = 0;
        foreach ($hand as $handcard) {
            $score += $handcard->score();
        }
        if ($score == 21 && count($hand) == 2) {
            return "Blackjack";
        } elseif ($score > 21) {
            return "busted";
        } elseif ($score == 21) {
            return "Twenty-One";
        } elseif (count($hand) >= 5 && $score <= 21) {
            return "Five Card Charlie";
        } else {
            return $score;
        }
    }
}


?>