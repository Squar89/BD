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
<title>Rejestracja</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>
<h1>Rejestracja</h1>

<?php
if ($_SESSION['user_logged_in']==true) {
    echo 'Jestes juz zalogowany jako <b>';
    echo $_SESSION[user_name];
    echo '</b>. <a href="logout.php">Wyloguj sie</a> lub <a href="home.php">przejdz do strony glownej</a>';
    exit();
}

if (!isset($_POST[new_username])) {
    echo 'Ooops, chyba zabladziles. <a href="login.php">Zarejestruj sie tutaj</a>';
    exit();
}

if ($_POST[new_username]=="") {
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
oci_bind_by_name($checkUsername, ":nazwa_uzytkownika", $_POST[new_username]);
oci_execute($checkUsername);
$rowCount = oci_fetch_all($checkUsername, $checkUsernameAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

if (!empty($checkUsernameAll)) {
    echo '<a href="login.php">Istnieje juz uzytkownik o danej nazwie! Zaloguj sie lub wybierz inna nazwe</a>';
    oci_close($connection);
    exit();
}

$addUser = oci_parse($connection, "INSERT INTO uzytkownik (nazwa_uzytkownika) VALUES ('{$_POST[new_username]}')");
oci_bind_by_name($addUser, ":nazwa_uzytkownika", $_POST[new_username]);
oci_execute($addUser);


$checkUsername = oci_parse($connection, "SELECT id FROM uzytkownik WHERE nazwa_uzytkownika = :nazwa_uzytkownika");
oci_bind_by_name($checkUsername, ":nazwa_uzytkownika", $_POST[new_username]);
oci_execute($checkUsername);
$rowCount = oci_fetch_all($checkUsername, $checkUsernameAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
if (empty($checkUsernameAll)) {
    echo 'Cos poszlo nie tak, <a href="login.php">sprobuj ponownie</a>';
    oci_close($connection);
    exit();
}
else {
    $_SESSION['user_id']=$checkUsernameAll[0][ID];
    $_SESSION['user_name']=$_POST[new_username];
    $_SESSION['user_logged_in']=true;

    echo 'Zostales poprawnie zarejestrowany! <a href="home.php">Kliknij tutaj, aby przejsc strony glownej</a>';
}

oci_close($connection);
?>

</hr>
</body>
</html>