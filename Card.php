<?php

class Card
{
    public const SUITS = ["schoppen", "klavers", "harten", "ruiten"];
    public const VALUES = ["2","3","4","5","6","7","8","9","10","boer","vrouw","heer","aas"];

    private string $suit = "";
    private string $value = "";

    function __construct($suit, $value)
    {
        $this->validateSuit($suit, $this::SUITS);
        $this->validateValue($value, $this::VALUES);
    }

    private function validateSuit($suit, $symbols) 
    {
        if (!in_array($suit, $symbols)) {
            throw new InvalidArgumentException("the symbol must be one of schoppen, klavers, harten, ruiten");
        } else {
            $this->suit = $suit;
        }
    }

    private function validateValue($value, $values) 
    {
        if (!in_array($value, $values)) {
            throw new InvalidArgumentException("2, 3, 4, 5, 6, 7, 8, 9, 10, boer, vrouw, heer, aas");
        } else {
            $this->value = $value;
        }
    }

    public function show()
    {
        if (strlen($this->value) > 2) {
            $this->value = ucfirst(substr($this->value, 0, 1));
        }
        if ($this->suit == "schoppen") {
            $temp = "♠";
            return $temp . $this->value;
        }
        if ($this->suit == "klavers") {
            $temp = "♣";
            return $temp . $this->value;
        }
        if ($this->suit == "harten") {
            $temp = "♥";
            return $temp . $this->value;
        }
        if ($this->suit == "ruiten") {
            $temp = "♦";
            return $temp . $this->value;
        }
    }

    public function score(): int
    {
        if (strlen($this->value) > 2) {
            $this->value = ucfirst(substr($this->value, 0, 1));
        }
        switch ($this->value) {
            case "2":
                return 2;
                break;
            case "3":
                return 3;
                break;
            case "4":
                return 4;
                break;
            case "5":
                return 5;
                break;
            case "6":
                return 6;
                 break;
            case "7":
                return 7;
                break;
            case "8":
                return 8;
                break;
            case "9":
                return 9;
                break;
            case "10":
                return 10;
                break;
            case "B":
                return 10;
                break;
            case "V":
                return 10;
                 break;
            case "H":
                return 10;
                break;
            case "A":
                return 11;
                break;
        }
    }
}


?>