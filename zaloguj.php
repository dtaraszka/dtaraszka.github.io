<?php
session_start(); //pozwala kozystac z sessi

if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
    header("Location: index.php");
    exit();
}

require_once "connect.php";
// dołancza plik i sprawdza czy nie został już wcześniej dołącony, jeśli tak to nie dołącza go ponownie (unika redundancji)
mysqli_report(MYSQLI_REPORT_STRICT);
try {
    $connect_db = new mysqli($host, $db_user, $db_password, $db_name);
    // pobranie informacji z pliku connect.php

    if ($connect_db->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {
        $login = $_POST['login'];
        $haslo = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        //htmlspecialchars konwertuje znaki specjalne na encje html
        //ENT_QUOTES konwertuje podwójne i pojedyńcze cudzysłowia

        //funkcja zabezpieczająca przed wstrzykiwaniem SQL przez użytkownika (mysqli_real_escape_string)
        //sprintf zapisuje sformatowany łańcuch do zmiennej i zostaje wstawiony w znakach procenta
        if ($rezult = $connect_db->query(sprintf("SELECT * FROM uzytkownicy WHERE name_user='%s'", mysqli_real_escape_string($connect_db, $login)))) {
            //uzyskuje liczbe wierszy w zstawie wyników
            $how_records = $rezult->num_rows;
            if ($how_records == 1) {
                //tworzy tablice asocjacyjną, do której zostana powkładane zmienne o tych samych nazwach co w bazie danych (fetch_assoc())
                // $column = $rezult->fetch_assoc();
                $column = mysqli_fetch_assoc($rezult);
                if (password_verify($haslo, $column['password_user'])) {


                    $_SESSION['zalogowany'] = true;

                    $_SESSION['id'] = $column['id_user'];
                    $_SESSION['user'] = $column['name_user'];
                    $_SESSION['email'] = $column['email_user'];

                    $_SESSION['password'] = $column['password_user'];

                    unset($_SESSION['blad']); //usunięcie sesyjną blad

                    //zwolnienie pamięci z niepotrzebnych rezultatów zapytania
                    // $rezult->close();
                    mysqli_free_result($rezult);

                    header("Location: witryna.php");
                } else {
                    $_SESSION['blad'] = '<span class="blad">Nieprawidłowy login lub hasło</span>';
                    header("Location: indexerro.php");
                }
            } else {
                $_SESSION['blad'] = '<span class="blad">Nieprawidłowy login lub hasło</span>';
                header("Location: indexerro.php");
            }
        }

        $connect_db->close(); //Zamkniecie bazy danych
    }
} catch (Exception $error) {
    echo "Błąd serwera";
}
