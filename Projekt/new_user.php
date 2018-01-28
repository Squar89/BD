<?php
session_start();
if (!($_SESSION['logged_in']==true)) {
    echo 'Odmowa dostepu. Musisz sie najpierw zalogowac. <a href="login.php">Zaloguj sie tutaj</a>';
    exit();
}

if (!isset($_POST[new_username])) {
    echo 'Nie jestes zalogowany. <a href="auth.php">Zaloguj sie tutaj</a>';
    exit();
}

if ($_POST[new_username]=="") {
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
oci_bind_by_name($checkUsername, ":nazwa_uzytkownika", $_POST[new_username]);
oci_execute($checkUsername);
$rowCount = oci_fetch_all($checkUsername, $checkUsernameAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

if (!empty($checkUsernameAll)) {
    echo '<a href="auth.php">Istnieje juz uzytkownik o danej nazwie! Zaloguj sie lub wybierz inna nazwe</a>';
    exit();
}

$addUser = oci_parse($connection, "INSERT INTO uzytkownik (nazwa_uzytkownika) VALUES ('{$_POST[new_username]}')");
oci_bind_by_name($addUser, ":nazwa_uzytkownika", $_POST[new_username]);
oci_execute($addUser);
echo '<a href="user.php">Zostales poprawnie zarejestrowany! Kliknij tutaj, aby przejsc do swojego konta</a>';

oci_close($connection);

?>