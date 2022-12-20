<?php
session_start(); //Rozpoczyna nową lub wznawia istnijącą sesję
//$_SESSION przechowuje informacje o użytkowniku do wykożystania na wielu stronach. Domyślnie trwa do momentu zamknięcia przeglądarki
if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) { //Sprawdza czy zmienne sesyjne istnieją i czy są prawdziwe
    header("Location: witryna.php"); //Przenosi na podaną stronę
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/styleglobalne.css">
    <link rel="stylesheet" href="style/logowaniestyle.css">
</head>

<body>
    <h1>Logowanie</h1>
    <div class="wrap">
        <form action="zaloguj.php" method="POST" class="aform">
            <label class="label-input">
                <p class="label-input__text">Login:</p>
                <input type="text" class="label-input__form ginput" name="login" required>
            </label>
            <label class="label-input">
                <p class="label-input__text">Hasło:</p>
                <input type="password" class="label-input__form ginput" name="password" required>
            </label>
            <div class="mini-wrap">
                <label class="btn-label">
                    <button type="button" class="btn btn__register">
                        <a href="rejestracja.php" class="btn__hiperlink">Rejestracja</a>
                    </button>

                    <span class="btn__lub">lub</span>
                    <button type="submit" class="btn btn__login">Zaloguj się</button>
                </label>
            </div>
        </form>
    </div>
</body>

</html>