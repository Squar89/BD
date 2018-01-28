<?php
session_start();
if ($_SESSION['logged_in']==true OR ($_POST['login']=="jw386401" AND $_POST['haslo']=="qwerty")) {
    $_SESSION['logged_in']=true;
    echo "Zostales poprawnie zalogowany!<br>";
}
else {
    echo "Odmowa dostepu.<br>";
}
?>