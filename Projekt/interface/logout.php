<?php
session_start();
if (!($_SESSION['auth']==true)) {
    echo 'Odmowa dostepu. Potwierdz swoja tozsamosc <a href="auth.php">tutaj</a>';
    exit();
}
?>

<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Wylogowywanie</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>

<?php
if ($_SESSION['user_logged_in']==false) {
    echo 'Ooops, chyba zabladziles. <a href="home.php">Przejdz do strony glownej</a>';
    exit();
}
else {
    $_SESSION['user_logged_in']=false;
    echo 'Wylogowano pomyslnie.';
}
?>

</hr>
</body>
</html>