<?php

/*
Chcemy stworzyć aplikację do ankietowania klientów.
Proszę zaprojektować strukturę DTO dla takiej aplikacji. 
Celem zadania nie jest zaprojektowanie bazy danych, lecz struktury obiektów, które będą zwracane na frontend podczas żądań do API. Choć oczywiście do pewnego stopnia te rzeczy są podobne.
Oto główne założenia aplikacji:

Pytań może być wiele rodzajów:
- pytania otwarte
- pytania tak / nie
- pytania tak / nie / nie wiem
- ocena w skali 1 - 10 (w tym skrajne odpowiedzi mają swoje opisy, np. dobrze/źle lub szybko/wolno)
- ocena w skali 1 - 5

Jedna ankieta może składać się z dowolnej ilości pytań dowolnego rodzaju.

Ankiet w całej aplikacji może być dużo. Ankety mają swój czas trwania (data od - data do)

Aplikacja z założenia tworzy ankiety anonimowe, tzn. nie trzeba się autoryzować aby odpowiedzieć na pytanie.

Proszę nie implementować żadnej funkcjonalności, wystarczą same klasy. Mile widziane jest użycie klas abstrakcyjnych.
*/

abstract class QuestionDTO {
    public $id;
    public $content;
}

class OpenQuestionDTO extends QuestionDTO {
   
}

class YesNoQuestionDTO extends QuestionDTO {
    
}

class YesNoIDKQuestionDTO extends QuestionDTO {
   
}

class ScaleQuestionDTO extends QuestionDTO {
    public $scale;
    public $minLabel;
    public $maxLabel;
}

class SurveyDTO {
    public $id;
    public $startTime;
    public $endTime;
    public $questions = array();
}
