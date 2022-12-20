<?php
if (isset($_POST['oldpassword']) && isset($_POST['newpassword']) && isset($_POST['newpassword2'])) {
    $wszystko_ok = true;

    $oldpass = $_POST['oldpassword'];
    $newpass = $_POST['newpassword'];
    $newpass2 = $_POST['newpassword2'];

    if ((strlen($newpass) < 8) || (strlen($newpass) > 20)) {
        $wszystko_ok = false;
        $_SESSION['error_passw'] = "Hasło musi posiadać od 8 do 20 znaków";
    }
    if ($newpass != $newpass2) {
        $wszystko_ok = false;
        $_SESSION['error_passw'] = "Hasło musi być takie same";
    }
    if (!password_verify($oldpass, $_SESSION['password'])) {
        $wszystko_ok = false;
        $_SESSION['error_passw'] = "Nieprawidłowe obecne hasło";
    }
    if (password_verify($oldpass, $_SESSION['password']) && $oldpass == $newpass) {
        $wszystko_ok = false;
        $_SESSION['error_passw'] = "Hasło jest takie samo ja stara";
    }
    try {
        $connect_db = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connect_db->connect_errno > 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            if ($wszystko_ok == true) {
                $new_hash_password = password_hash($newpass, PASSWORD_DEFAULT);

                if ($connect_db->query("UPDATE uzytkownicy SET password_user='$new_hash_password' WHERE id_user=$_SESSION[id]")) {
                    header("Location: logout.php");
                } else {
                    throw new Exception($connect_db->error);
                }
            }
            // $connect_db->close();
        }
    } catch (Exception $error) {
        echo "Błąd serwera";
        echo $error;
    }
}
