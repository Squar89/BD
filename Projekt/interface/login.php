<?php
session_start();
if (!($_SESSION['auth']==true)) {
    echo 'Odmowa dostepu. Potwierdz swoja tozsamosc <a href="auth.php">tutaj</a>';
    exit();
}
?>

<html>
<head>
<title>Logowanie</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>
<h1>Mam juz konto</h1>
<form action='user.php' method='post'>
Nazwa uzytkownika: <input type='text' name='username' /><br>
<input type='Submit' value='Wejdz'>
</form>
</hr>
<hr>
<h1>Chce sie zarejestrowac</h1>
<form action='new_user.php' method='post'>
Nazwa uzytkownika: <input type='text' name='new_username' /><br>
<input type='Submit' value='Zarejestruj'>
</form>
</hr>
</body>
</html>