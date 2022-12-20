<?php
session_start();
//Sprawdza czy zmienna sesyjna 'zalogowany' nie istnieje i jeśli jest true przenosi do index.php i kończy działanie(nie wyświetla dalszej zawartości strony)
if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
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
    <link rel="stylesheet" href="style/stylemain.css">

</head>

<body>
    <div class="blur2">
        <div class="wrap-motyw">
            <span class="wrap-motyw__span">Zmiana motywu</span>
            <label class="wrap-motyw__label">
                <input type="checkbox" class="cbox" />
                <div class="wrap-motyw__slider round"></div>
            </label>
        </div>
        <?php
        require_once "connect.php";

        require_once "setname.php";
        require_once "deleteuser.php";

        require_once "setpassword.php";


        // $connect_db->close();
        echo '<p class="hellow">Witaj ' . '<span class="nameUser">' . $_SESSION['user'] . '</span>' . '</p>';
        require_once "datatime.php";

        ?>
        <div class="menu ch-menu">Menu</div>
        <nav>
            <p class="menu__name">Zmień nazwe użytkownika</p>
            <form action="" class="form-name aform" method="post">
                <input type="text" class="form-name__newname ginput form-newNamePassw" name="newnamea" placeholder="Nowa nazwa" required>
                <?php
                if (isset($_SESSION['error_name'])) {
                    echo '<div class="error">' . $_SESSION['error_name'] . '</div>';
                    unset($_SESSION['error_name']);
                }
                ?>
                <input type="submit" class="btn form-name__btn" value="Zmiana nazwy" name="zmiana">
            </form>
            <p class="menu__passw">Zmiana hasła</p>
            <form action="" class="form-passw aform" method="post">
                <input type="password" class="form-passw__newpassw ginput form-newNamePassw" placeholder="Obecne hasło" name="oldpassword" required>
                <input type="password" class="form-passw__newpassw ginput form-newNamePassw" placeholder="Nowe hasło" name="newpassword" required>
                <input type="password" class="form-passw__newpassw ginput form-newNamePassw" placeholder="Powtórz hasło" name="newpassword2" required>
                <?php
                if (isset($_SESSION['error_passw'])) {
                    echo '<div class="error">' . $_SESSION['error_passw'] . '</div>';
                    unset($_SESSION['error_passw']);
                }
                ?>
                <input type="submit" class="btn form-passw__btn" value="Zmień hasło">
            </form>
            <!-- usnięcie konta -->
            <button class="btn delete">Usuń konto</button>

            <?php
            echo '<a href="logout.php" class="hiperlink-out">Wyloguj się</a>';
            ?>
        </nav>

        <div class="clock info-dt">Jest godzina <span></span> czasu lokalnego.</div>
        <div class="wrap">
            <form action="witryna.php" class="form aform" method="GET">
                <span class="form__span">Kalkulator</span>
                <label class="form__label">
                    <input type="number" name="liczba" class="form__number" placeholder="Liczba 1" required></label>
                <select name="wyb" class="form__znak">
                    <option value="d1">+</option>
                    <option value="d2">-</option>
                    <option value="d3">*</option>
                    <option value="d4">/</option>
                    <option value="d5">%</option>
                </select>
                <label class="form__label">
                    <input type="number" name="liczba2" class="form__number" placeholder="Liczba 2" required></label>
                <?php
                require_once "kalkulator.php";
                ?>
                <span class="wynikborder"></span>
                <button type="submit" name="btn" class="btn form__btn">Wyświetl wynik</button>
            </form>

        </div>
    </div>
    <div class="popup">
        <div class="popup-mini">
            <h2>Czy na pewno chcesz usnuąć konto?</h2>
            <p class="popup-mini__p">Twoje konto zostanie usunięte na zawsze.</p>

            <form action="" class="popup-mini__form" method="post">
                <input type="button" class="btn delete2 popup-mini__input" value="Nie">
                <input type="submit" class="btn popup-mini__input" value="Tak" name="tak">
            </form>

            <button class="btn delete3 popup-mini__x">+</button>
        </div>
    </div>

    <script src="script/delete.js"></script>
    <script src="script/menu.js"></script>
    <script src="script/main.js"></script>
    <script src="script/motyw.js"></script>

</body>

</html>