<?php
//blueprint voor het maken van de kaarten die gebruikt worden
class Card
{
    private string $suit;
    private string $value;

    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function show(): string
    {
        //geeft karakters aan de kaarten
        $karakter = '';
        switch ($this->suit) {
            case 'Harten':
                $karakter = '♥';
                break;
            case 'Ruiten':
                $karakter = '♦';
                break;
            case 'Klaveren':
                $karakter = '♣';
                break;
            case 'Schoppen':
                $karakter = '♠';
                break;
            default:
                $karakter = '';
                break;
        }
//geeft afkortingen
        $afkorting = $this->value;
        if ($afkorting === 'Vrouw') {
            $afkorting = 'V';
        } elseif ($afkorting === 'Heer') {
            $afkorting = 'H';
        } elseif ($afkorting === 'Aas') {
            $afkorting = 'A';
        } elseif ($afkorting === 'Boer') {
            $afkorting = 'B';
        }

        return $karakter . $afkorting;
    }
//geeft scores aan boer, vrouw, heer en aas
    public function score(): int
    {
        if (in_array($this->value, ['Boer', 'Vrouw', 'Heer'])) {
            return 10;
        } elseif ($this->value === 'Aas') {
            return 11;
        } else {
            return intval($this->value);
        }
    }
}

?>