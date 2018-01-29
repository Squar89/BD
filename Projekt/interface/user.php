<?php
session_start();
if (!($_SESSION['logged_in']==true)) {
    echo 'Odmowa dostepu. Musisz sie najpierw zalogowac. <a href="login.php">Zaloguj sie tutaj</a>';
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
<a href="auth.php">Zaloguj sie</a><br>
<a href="listaFilmow.php">Lista filmow</a><br>
<hr>
<h1>Logowanie</h1>

<?php
if ($_SESSION['user_logged_in']==true) {
    echo 'Jestes juz zalogowany jako $_SESSION[user_name]';
}

if (!isset($_POST[username])) {
    echo 'Nie jestes zalogowany. <a href="auth.php">Zaloguj sie tutaj</a>';
    exit();
}

if ($_POST[username]=="") {
    echo 'Bledna nazwa uzytkownika! <a href="auth.php">Sprobuj ponownie</a>';
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
    echo '<a href="auth.php">Nie ma takiego uzytkownika. Upewnij sie, ze poprawnie wpisales login lub zaloz nowe konto</a>';
    exit();
}
else {
    $_SESSION['user_id']=$checkUsernameAll[0][ID];
    $_SESSION['user_name']=$_POST[username];
    $_SESSION['user_logged_in']=true;

    echo 'Zostales poprawnie zalogowany! <a href="user.php">Przejdz tutaj</a>';
    exit();
}
?>

</hr>
</body>
</html>