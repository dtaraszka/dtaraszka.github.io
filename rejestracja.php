<?php
session_start();
//sprawdzenie czy podane wartości są zawarte w formularzu.
//pobiera z formularza poniżej odnosi sie do nazwy z pliku
if (isset($_POST['name']) && (isset($_POST['email'])) && (isset($_POST['password'])) && (isset($_POST['password2']))) {
    //Udana walidacja(flaga)
    $wszystko_ok = true;

    //Sprawdzenie name
    $nick = $_POST['name'];

    //Sprawdzenie długośći name
    if ((strlen($nick) < 3) || (strlen($nick) > 20)) {
        $wszystko_ok = false;
        $_SESSION['error_name'] = "Nazwa musi posiadać od 3 do 20 znaków!";
    }
    if (ctype_alnum($nick) == false) {
        $wszystko_ok = false;
        $_SESSION['error_name'] = "Nazwa może składać się z liter i cyfr(bez polskich znaków)";
    }
    //Blokada nazwy admin i podobnych
    if (strstr($nick, "admin") || (strstr($nick, "Admin"))) {
        $wszystko_ok = false;
        $_SESSION['error_name'] = "Nazwa nie może zawierać słowa admin";
    }

    //Sprawć poprawność adresu email
    $email = $_POST['email'];
    $email_supp = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($email_supp, FILTER_VALIDATE_EMAIL) == false) || ($email_supp != $email)) {
        $wszystko_ok = false;
        $_SESSION['error_email'] = "Podaj prawidłowy adres email";
    }

    //Sprawdzanie hasła
    $haslo1 = $_POST['password'];
    $haslo2 = $_POST['password2'];

    if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
        $wszystko_ok = false;
        $_SESSION['error_passw'] = "Hasło musi posiadać od 8 do 20 znaków";
    }

    if ($haslo1 != $haslo2) {
        $wszystko_ok = false;
        $_SESSION['error_passw'] = "Hasło musi być takie same";
    }

    //Hashowanie hasła
    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


    //recatcha v2
    $sekret = '6LeK7pQjAAAAABJj04z18GX436q2TDH12gWTJHJA';
    $response = $_POST['g-recaptcha-response'];
    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $sekret . '&response=' . $response);

    $odpowiedz = json_decode($sprawdz);
    if ($odpowiedz->success == false) {
        $wszystko_OK = false;
        $_SESSION['error_bot'] = "Potwierdź, że nie jesteś botem!";
    } else {
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $connect_db = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connect_db->connect_errno > 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                //Czy email juz istnieje?
                $rezult = $connect_db->query("SELECT id_user FROM uzytkownicy WHERE email_user='$email'");
                if (!$rezult) throw new Exception($connect_db->error);
                //połaczenie warunków
                $ile_takich_meili = $rezult->num_rows;
                if ($ile_takich_meili > 0) {
                    $wszystko_ok = false;
                    $_SESSION['error_email'] = "Istnieje już konto z takim meilem";
                }

                //Czy nick jest juz zarezerwowany?
                $rezult = $connect_db->query("SELECT id_user FROM uzytkownicy WHERE name_user='$nick'");
                if (!$rezult) throw new Exception($connect_db->error);
                //to samo co wyzej
                $ile_takich_nicku = $rezult->num_rows;
                if ($ile_takich_nicku > 0) {
                    $wszystko_ok = false;
                    $_SESSION['error_name'] = "Istneje juz taka osoba";
                }

                if ($wszystko_ok == true) {
                    //Dodanie do bazy nowego użytkownika z zahaszowanym hasłem
                    if ($connect_db->query("INSERT INTO uzytkownicy VALUES(NULL, '$nick', '$haslo_hash','$email')")) {
                        $_SESSION['sukces_rejstracji'] = true;
                        header("Location: witamy.php");
                    } else {
                        throw new Exception($connect_db->error);
                    }
                }
                $connect_db->close();
            }
        } catch (Exception $error) {
            //Komunikat dla użytkownika
            echo "Błąd serwera";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link rel="stylesheet" href="style/styleglobalne.css">
    <link rel="stylesheet" href="style/registerstyle.css">
</head>

<body>
    <div class="wrap">
        <h1>Rejestracja</h1>
        <form action="" method="post" class="aform">
            <label class="main-label">
                <p class="main-label__infoform">Login:</p>
                <input type="text" name="name" class="main-label__stylinput" required>
                <?php
                if (isset($_SESSION['error_name'])) {
                    echo '<div class="error">' . $_SESSION['error_name'] . '</div>';
                    unset($_SESSION['error_name']);
                }
                ?>
            </label>
            <label class="main-label">
                <p class="main-label__infoform">E-mail</p>
                <input type="email" name="email" class="main-label__stylinput" required>
                <?php
                if (isset($_SESSION['error_email'])) {
                    echo '<div class="error">' . $_SESSION['error_email'] . '</div>';
                    unset($_SESSION['error_email']);
                }
                ?>
            </label>
            <label class="main-label">
                <p class="main-label__infoform">Hasło:</p>
                <input type="password" name="password" class="main-label__stylinput" required>
                <?php
                if (isset($_SESSION['error_passw'])) {
                    echo '<div class="error">' . $_SESSION['error_passw'] . '</div>';
                    unset($_SESSION['error_passw']);
                }
                ?>
            </label>
            <label class="main-label">
                <p class="main-label__infoform">Powtórz hasło:</p>
                <input type="password" name="password2" class="main-label__stylinput" required>
            </label>
            <label class="regulamin">
                <input type="checkbox" class="regulamin__stylinput" name="regulamin" required><span class="regulamin__akcept"> Akceptacja</span>
                <a href="#" class="regulamin__hiperlink">regulaminu</a>
            </label>

            <div class="g-recaptcha captcha" data-sitekey="6LeK7pQjAAAAAKajyuTbIYcx6TVqZx03EBha9qYZ" required></div>

            <?php
            if (isset($_SESSION['error_bot'])) {
                echo '<div class="error captcha__error">' . $_SESSION['error_bot'] . '</div>';
                unset($_SESSION['error_bot']);
            }
            ?>
            <div class="mini-wrap-btn">
                <label class="btn-label">
                    <button type="button" class="btn btn__index">
                        <a href="index.php" class="btn__hiperlink">Zaloguj się</a>
                    </button>
                    <button type="submit" class="btn btn__register">Zarejestruj się</button>
                </label>
            </div>
        </form>
    </div>
</body>

</html>