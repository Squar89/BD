<?php
session_start();
if (!($_SESSION['logged_in']==true)) {
    echo "Odmowa dostepu. Musisz sie najpierw zalogowac.<br>";
    exit();
}

$connection = oci_connect($_SESSION['login'], $_SESSION['haslo'], null, 'AL32UTF8');
if (!$connection) {
    $error = oci_error();
    echo "Blad w trakcie laczenia sie z baza! ({$error['message']})";
    exit();
}

$checkUsername = oci_parse($connection, "SELECT id FROM uzytkownik WHERE nazwa_uzytkownika = {$_POST[new_username]}");
oci_execute($checkUsername);
$rowCount = oci_fetch_all($checkUsername, $checkUsernameAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
if (rowCount != 0) {
    echo "Istnieje już uzytkownik o danej nazwie! Zaloguj sie lub wybierz inna nazwe";#Dodaj link
    exit();
}

$addUser = oci_parse($connection, "INSERT INTO uzytkownik (nazwa_uzytkownika) VALUES ({$_POST[new_username]})");
oci_execute($addUser);
echo "Zostałeś poprawnie zarejestrowany! Kliknij tutaj, aby przejść do swojego konta";#Dodaj link

oci_close($connection);

?>