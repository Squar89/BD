<?php
session_start();
if ($_SESSION['auth']==true OR ($_POST['login']=="jw386401" AND $_POST['haslo']=="qwerty")) {
    $_SESSION['auth']=true;
    $_SESSION['login']="jw386401";
    $_SESSION['haslo']="qwerty";
}
else {
    echo 'Odmowa dostepu. Potwierdz swoja tozsamosc <a href="auth.php">tutaj</a>';
    exit();
}
?>

<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Home</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="listaFilmow.php">Lista filmow</a><br>
<hr>
<h1>Home</h1>

<?php
if ($_SESSION['user_logged_in']==false) {
    echo 'Wybierz konto lub zaloz nowe jesli jeszcze tego nie robiles <a href="login.php">tutaj</a>';
    exit();
}
else {
    echo 'Jestes zalogowany jako <b>';
    echo $_SESSION[user_name];
    echo '</b>(<a href="logout.php">Wyloguj</a>)';
}

echo "<br>tutaj bedą jakieś dalsze linki<br>";
?>

</hr>
</body>
</html>