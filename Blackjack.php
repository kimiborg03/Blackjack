<?php

require_once 'Player.php';
class Blackjack
{
    //berekent de score van een hand
    public function scoreHand(array $hand): string
    {
        $score = 0;
        $numAces = 0;
        $isBlackjack = false;
//telt de score van iedere kaart in de hand 
        foreach ($hand as $card) {
            $score += $card->score();
            //kijkt of er een aas is
            if ($card->score() === 'Aas') {
                $numAces++;
            }
        }
        //kijkt of de hand een blackjack heeft
        if (count($hand) === 2 && $score === 21) {
            $isBlackjack = true;
        }
        //controleert op busted
        if ($score > 21) {
            return 'Busted';
        }
        //controleert op blackjack
        if ($isBlackjack) {
            return 'Blackjack';
        }
        //controleert op twenty-one
        if ($score === 21) {
            return 'Twenty-One';
        }
        //controleert op five card charlie
        if (count($hand) >= 5 && $score <= 21) {
            return 'Five Card Charlie';
        }
        return strval($score);
    }
}
