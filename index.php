<?php

require_once 'Blackjack.php';
require_once 'Card.php';
require_once 'Dealer.php';
require_once 'Deck.php';
require_once 'Player.php';


$deck = new Deck();
$blackjack = new Blackjack();
$dealer = new Dealer($blackjack, $deck);

$dealer->addPlayer(new Player('Dealer'));
$add = true;

while ($add == true) {
    $answer = (string)readline("Add player (y) or don't (n) ... ");
    if ($answer == "y") {
        $name = (string)readline("What is your name? ... ");
        $dealer->addPlayer(new Player($name));
    } elseif ($answer == "n") {
        $add = false;
    }
}
$dealer->playGame();

?>
