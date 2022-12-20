<?php
$nameday = date("l");
$dzien = date("d");
$miesiac = date("m");
$rok = date("Y");
$time = new DateTime();

if ($nameday == "Monday") $nameday = "Poniedziałek";
elseif ($nameday == "Tuesday") $nameday = "Wtorek";
elseif ($nameday == "Wednesday") $nameday = "Środe";
elseif ($nameday == "Thursday") $nameday = "Czwartek";
elseif ($nameday == "Friday") $nameday = "Piątek";
elseif ($nameday == "Saturday") $nameday = "Sobote";
elseif ($nameday == "Sunday") $nameday = "Niedziele";
echo '<p class="info-dt">Dzisiaj mamy ' . $nameday . " - " . $dzien . "/" . $miesiac . "/" . $rok . '</p>';
echo '<p class="info-dt">Jest godzina ' . $time->format("h:i:s a") . ' czasu serwerowego.</p>';
