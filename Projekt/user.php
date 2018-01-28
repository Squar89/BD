<?php
session_start();
if (!($_SESSION['logged_in']==true)) {
    echo "Odmowa dostepu. Musisz sie najpierw zalogowac.<br>";
    exit();
}



?>