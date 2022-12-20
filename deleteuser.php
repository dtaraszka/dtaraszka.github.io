<?php
if (isset($_POST['tak']) && $_POST['tak'] == true) {
    // require_once "connect.php";
    try {
        $connect_db = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connect_db->connect_errno > 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $rezult = $connect_db->query("SELECT id_user FROM uzytkownicy WHERE name_user='$newname'");
            if (!$rezult) throw new Exception($connect_db->error);
            if ($connect_db->query("DELETE FROM uzytkownicy WHERE id_user=$_SESSION[id]")) {
                header("Location: logout.php");
            } else {
                throw new Exception($connect_db->error);
            }
            $connect_db->close();
        }
    } catch (Exception $error) {
        echo "Błąd serwera";
    }
}
