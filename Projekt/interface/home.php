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
<title>Strona glowna</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>
<h1>Strona glowna</h1>

<?php
if ($_SESSION['user_logged_in']==false) {
    echo '<h3>Witaj na Brak Nazwy!</h3>';
    echo 'Wszystko do czego aktualnie masz dostep znajduje sie u gory strony.<br>';
    echo 'Aktualnie mozesz jedynie przegladac liste filmow oraz zalozyc konto, reszta funkcji bedzie dostepna po zalogowaniu.<br>';
    echo 'Jesli jeszcze tego nie zrobiles, to <a href="login.php">zaloz konto</a><br>';
    echo 'Jesli jestes juz uzytkownikiem Brak Nazwy, to <a href="login.php">zaloguj sie</a><br>';
    exit();
}
else {
    echo 'Jestes zalogowany jako <b>';
    echo $_SESSION[user_name];
    echo '</b>(<a href="logout.php">Wyloguj</a>)<br><br>';

    echo '<a href="do_obejrzenia.php">Twoja lista filmow do obejrzenia</a><br>';
    echo '<a href="ocen_film.php">Ocen film</a><br>';
}
?>

</hr>
</body>
</html>