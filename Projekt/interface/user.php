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
<title>Logowanie</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="listaFilmow.php">Lista filmow</a><br>
<hr>
<h1>Logowanie</h1>

<?php
if ($_SESSION['user_logged_in']==true) {
    echo 'Jestes juz zalogowany jako <b>';
    echo $_SESSION[user_name];
    echo '</b>. <a href="logout.php">Wyloguj sie</a> lub <a href="home.php">przejdz do strony glownej</a>';
    exit();
}

if (!isset($_POST[username])) {
    echo 'Ooops, chyba zabladziles. <a href="login.php">Zaloguj sie tutaj</a>';
    exit();
}

if ($_POST[username]=="") {
    echo 'Bledna nazwa uzytkownika! <a href="login.php">Sprobuj ponownie</a>';
    exit();
}

$connection = oci_connect($_SESSION['login'], $_SESSION['haslo'], null, 'AL32UTF8');
if (!$connection) {
    $error = oci_error();
    echo "Blad w trakcie laczenia sie z baza! ({$error['message']})";
    exit();
}

$checkUsername = oci_parse($connection, "SELECT id FROM uzytkownik WHERE nazwa_uzytkownika = :nazwa_uzytkownika");
oci_bind_by_name($checkUsername, ":nazwa_uzytkownika", $_POST[username]);
oci_execute($checkUsername);
$rowCount = oci_fetch_all($checkUsername, $checkUsernameAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

if (empty($checkUsernameAll)) {
    echo '<a href="login.php">Nie ma takiego uzytkownika. Upewnij sie, ze poprawnie wpisales login lub zaloz nowe konto</a>';
    exit();
}
else {
    $_SESSION['user_id']=$checkUsernameAll[0][ID];
    $_SESSION['user_name']=$_POST[username];
    $_SESSION['user_logged_in']=true;

    echo 'Zostales poprawnie zalogowany! <a href="home.php">Przejdz tutaj</a>';
    exit();
}
?>

</hr>
</body>
</html>