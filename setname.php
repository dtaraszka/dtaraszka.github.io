<?php
//ZMIANA NAZYW UŻYTKOWNIKA
if (isset($_POST['newnamea'])) {
    $wszystko_ok = true;

    $newname = $_POST['newnamea'];

    if ((strlen($newname) < 3) || (strlen($newname) > 20)) {
        $wszystko_ok = false;
        $_SESSION['error_name'] = "Nazwa musi posiadać od 3 do 20 znaków";
    }
    if (ctype_alnum($newname) == false) {
        $wszystko_ok = false;
        $_SESSION['error_name'] = "Nazwa może składać się tylko z liter i cyfr (bez polskich znaków)";
    }
    if (strstr($newname, "admin") || (strstr($newname, "Admin"))) {
        $wszystko_ok = false;
        $_SESSION['error_name'] = "Nazwa nie może zawierać słowa admin";
    }

    // require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $connect_db = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connect_db->connect_errno > 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $rezult = $connect_db->query("SELECT id_user FROM uzytkownicy WHERE name_user='$newname'");
            if (!$rezult) throw new Exception($connect_db->error);
            $ile_takich_nicku = $rezult->num_rows;
            if ($ile_takich_nicku > 0) {
                $wszystko_ok = false;
                $_SESSION['error_name'] = "Istnieje już taka osoba";
            }
            if ($wszystko_ok == true) {
                if ($connect_db->query("UPDATE uzytkownicy SET name_user='$newname' WHERE id_user=$_SESSION[id]")) {
                    header("Location: logout.php");
                } else {
                    throw new Exception($connect_db->error);
                }
            }
            $connect_db->close();
        }
    } catch (Exception $error) {
        echo "Błąd serwera";
    }
}
