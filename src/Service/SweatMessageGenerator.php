<?php

// src/Service/SweatMessageGenerator.php
namespace App\Service;

class SweatMessageGenerator
{

    private $idMessage;


    public function __construct($idMessage)
    {
        $this->idMessage = $idMessage;
        //var_dump($idMessage);
    }

    public function getSweatMessage()
    {
        $messages = [
            'Merci à toi !',
            'Belle journée, n\'est-ce pas ?',
            'Ca fait plaisir de te voir !',
            'Tu es tellement formidable !',
        ];

        if($this->idMessage != ""){
          $index = $this->idMessage;
        } else {
          $index = array_rand($messages);
        }

        return $messages[$index];
    }
}

?>
