<?php
if (isset($_GET['btn']) && is_numeric($_GET['liczba']) && is_numeric($_GET['liczba2'])) {

    $liczba = $_GET['liczba'];
    $liczba2 = $_GET['liczba2'];
    $wyb = $_GET['wyb'];

    if ($wyb == "d1") echo '<p class="wynik">' . "Suma $liczba i $liczba2 wynosi: " . ($liczba + $liczba2) . '</p>';
    elseif ($wyb == "d2") echo '<p class="wynik">' . "Różnica $liczba i $liczba2 wynosi: " . ($liczba - $liczba2) . '</p>';
    elseif ($wyb == "d3") echo '<p class="wynik">' . "Iloczyn $liczba i $liczba2 wynosi: " . ($liczba * $liczba2) . '</p>';
    elseif (!$liczba2 == 0 && $wyb == "d4") echo '<p class="wynik">' . "Iloraz $liczba i $liczba2 wynosi: " . ($liczba / $liczba2) . '</p>';
    elseif (!$liczba2 == 0 && $wyb == "d5") echo '<p class="wynik">' . "Modulo $liczba i $liczba2 wynosi: " . ($liczba % $liczba2) . '</p>';
    elseif ($liczba2 == 0 && $wyb == "d4" || $wyb == "d5") echo '<p class="wynik ostrz">Nie dzieimy przez 0!</p>';
}
