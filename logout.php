<?php
session_start();
session_unset(); //Niszczy wszystkie zmienne sesji
header("Location: index.php");
