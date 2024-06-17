<?php

require_once 'Card.php';

class Player
{
    private string $name;
    private array $hand = [];
//constructor om nieuwe spelers te maken
    public function __construct(string $name)
    {
        $this->name = $name;
    }
//geeft een kaart aan de hand van de speler
    public function addCard(Card $card): void
    {
        $this->hand[] = $card;
    }
    //laat de kaarten van de speler zien
    public function showHand(): string
    {
        $handString = $this->name . " has";
        foreach ($this->hand as $card) {
            $handString .= " " . $card->show();
        }
        return $handString;
    }
//geeft de naam van de speler terug
    public function getName(): string
    {
        return $this->name;
    }
    //geeft de hand van de speler terug
    public function getHand(): array
    {
        return $this->hand;
    }
    //stelt de hand van de speler in
    public function setHand(array $hand): void
    {
        $this->hand = $hand;
    }
}