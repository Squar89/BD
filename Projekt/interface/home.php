<?php
session_start();
if ($_SESSION['logged_in']==true OR ($_POST['login']=="jw386401" AND $_POST['haslo']=="qwerty")) {
    $_SESSION['logged_in']=true;
    $_SESSION['login']="jw386401";
    $_SESSION['haslo']="qwerty";
}
else {
    echo 'Odmowa dostepu. Musisz sie najpierw zalogowac. <a href="login.php">Zaloguj sie tutaj</a>';
    exit();
}
?>

<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Home</title>
</head>
<body>
<hr>
<a href="home.php">Strona glowna</a><br>
<a href="auth.php">Zaloguj sie</a><br>
<a href="listaFilmow.php">Lista filmow</a><bre>
</hr>
<h1>Home</h1>

<?php
if ($_SESSION['user_logged_in']==false) {
    echo 'Wybierz konto lub zaloz nowe jesli jeszcze tego nie robiles <a href="auth.php">tutaj</a>';
    exit();
}
else {
    echo 'Jestes zalogowany jako jako $_SESSION[user_name]. <a href="logout.php">Wyloguj</a>';
}

echo "<br>tutaj bedą jakieś dalsze linki<br>";
?>

</body>
</html>