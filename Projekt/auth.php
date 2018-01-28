<?php
session_start();
if ($_SESSION['logged_in']==true OR ($_POST['login']=="jw386401" AND $_POST['haslo']=="qwerty")) {
    $_SESSION['logged_in']=true;
    $_SESSION['login']="jw386401";
    $_SESSION['haslo']="qwerty";
    echo "Zostales poprawnie zalogowany!<br>";
}
else {
    echo "Odmowa dostepu. Musisz sie najpierw zalogowac.<br>";
}
?>