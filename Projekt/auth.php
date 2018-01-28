<?php
session_start();
if (!($_SESSION['logged_in']==true)) {
    echo "Odmowa dostepu. Musisz sie najpierw zalogowac.<br>";
    exit();
}

?>
<html>
<head>
<title>Logowanie</title>
</head>
<body>
<h1>Mam juz konto</h1>
<form action='user.php' method='post'>
Nazwa uzytkownika: <input type='text' name='username' /><br>
<input type='Submit' value='Wejdz'>
</form>
<hr>
<h1>Chce sie zarejestrowac</h1>
<form action='new_user.php' method='post'>
Nazwa uzytkownika: <input type='text' name='new_username' /><br>
<input type='Submit' value='Zarejestruj'>
</form>
</hr>
</body>
</html>