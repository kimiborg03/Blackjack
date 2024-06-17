<?php

require_once 'Card.php';
//maakt het deck aan
class Deck
{
    private array $cards = [];
    public function __construct()
    {
        $this->generateCards();
    }
    //maakt de kaarten aan
    private function generateCards(): void
    {
        $suits = ['Harten', 'Ruiten', 'Klaveren', 'Schoppen'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Boer', 'Vrouw', 'Heer', 'Aas'];
        //genereert iedere combinatie
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }
    //pakt een kaart van het deck
    public function drawCard(): Card
    {
        if (empty($this->cards)) {
            throw new Exception("Deck is leeg");
        }
        return array_pop($this->cards);
    }
    public function shuffle(): void
    {
        shuffle($this->cards);
    }
}

?>