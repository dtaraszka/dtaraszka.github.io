<?php
session_start();
if (!isset($_SESSION['sukces_rejstracji'])) {
    header("Location: index.php");
    exit();
} else {
    unset($_SESSION['sukces_rejstracji']);
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
    <link rel="stylesheet" href="style/hellostyl.css">
</head>

<body>
    <h1>Dziękujemy za rejestracje w serwisie</h1>
    <a href="index.php">Zaloguj sie</a>
</body>

</html>