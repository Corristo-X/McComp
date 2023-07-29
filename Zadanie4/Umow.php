<?php

/*
Prosze napisać prosty program, który będzie pomagał grupie znajomych umówić się na konkretną godzinę.

Każda z osób wywoła nasz skrypt z parametrami oznaczającymi jego imię i preferowaną godzinę, np.
http://serwer/Umow.php?kto=KamilS&godzina=12:00

Strona, która się otworzy powinna pokazywać jak zagłosowali inni koledzy, np:

16:00 - 3 osoby (Michał, Arek, Kasia)
16:30 - 2 osoby (KamilC, Łukasz)
12:00 - 1 osoba (kamilS)

Mile widziane jest grupowanie odpowiedzi i sortowanie ich.
Wejście na stronę drugi raz przez tą samą osobę ma zmienić jego głos a nie dodać nowy.

Do przechowywania danych wystarczy prosty plik tekstowy na serwerze, proszę wybrać najprostszą dla siebie metodę.

Z powodu ogranicznonego czasu na wykonanie nie jest wymagane dopracowanie wyglądu strony, oraz wprowadzanie javascript.
*/


$file_name = 'data.txt';
$data = [];

// Sprawdzenie, czy plik istnieje i zawiera jakieś dane
if (file_exists($file_name) && filesize($file_name) > 0) {
    $file = fopen($file_name, 'r');
    if (flock($file, LOCK_SH)) { // Dodajemy blokadę do odczytu
        $serialized_data = fread($file, filesize($file_name));
        $data = @unserialize($serialized_data);
        if ($data === false) {
            // Usuwamy uszkodzone dane
            $data = [];
        }
        flock($file, LOCK_UN); // Usuwamy blokadę
    }
    fclose($file);
}

// Sprawdzenie, czy skrypt został wywołany z odpowiednimi parametrami
if (isset($_GET['kto']) && isset($_GET['godzina'])) {
    $name = $_GET['kto'];
    $time = $_GET['godzina'];

    // Dodanie lub zmiana głosu
    $data[$name] = $time;

    // Zapisanie zmienionych danych
    $file = fopen($file_name, 'w');
    if (flock($file, LOCK_EX)) { // Dodajemy blokadę do zapisu
        fwrite($file, serialize($data));
        flock($file, LOCK_UN); // Usuwamy blokadę
    }
    fclose($file);
}

// Przygotowanie tablicy do grupowania wyników
$result = [];

// Grupowanie wyników
if (is_array($data)) {
    foreach ($data as $name => $time) {
        $result[$time][] = $name;
    }
}

// Sortowanie wyników
ksort($result);

// Wyświetlanie wyników
foreach ($result as $time => $names) {
    echo $time . ' - ' . count($names) . ' osoby (' . implode(', ', $names) . ')<br>';
}
?>
