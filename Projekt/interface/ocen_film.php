<?php
session_start();
if (!($_SESSION['auth']==true)) {
    echo 'Odmowa dostepu. Potwierdz swoja tozsamosc <a href="auth.php">tutaj</a>';
    exit();
}

if ($_SESSION['user_logged_in']==false) {
    echo 'Ooops, chyba zabladziles. <a href="home.php">Wroc do strony glownej</a>';
    exit();
}

if (isset($_POST['id_filmu']) AND isset($_POST['ocena'])) {
    $connection = oci_connect($_SESSION['login'], $_SESSION['haslo'], null, 'AL32UTF8');
    if (!$connection) {
        $error = oci_error();
        echo "Blad w trakcie laczenia sie z baza! ({$error['message']})";
        exit();
    }

    $check_if_exists = oci_parse($connection, "SELECT * FROM ocena_filmu WHERE uzytkownik_id = :id_uzytkownika AND film_id = :film_id");
    oci_bind_by_name($check_if_exists, ":id_uzytkownika", $_SESSION['user_id']);
    oci_bind_by_name($check_if_exists, ":film_id", $_POST['id_filmu']);
    oci_execute($check_if_exists);
    $rowCount = oci_fetch_all($check_if_exists, $check_if_existsAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

    if (empty($check_if_existsAll)) {
        if ($_POST['opinia']== "" OR $_POST['opinia']=="Podziel sie swoimi odczuciami na temat filmu") {
            $ocen = oci_parse($connection, "INSERT INTO ocena_filmu (film_id, ocena, uzytkownik_id) VALUES (:film_id, :ocena, :uzytkownik_id)");
        }
        else {
            $ocen = oci_parse($connection, "INSERT INTO ocena_filmu (film_id, ocena, opinia, uzytkownik_id) VALUES (:film_id, :ocena, :opinia, :uzytkownik_id)"); 
            oci_bind_by_name($ocen, ":opinia", $_POST['opinia']);  
        }
        oci_bind_by_name($ocen, ":film_id", $_POST['id_filmu']);
        oci_bind_by_name($ocen, ":ocena", $_POST['ocena']);
        oci_bind_by_name($ocen, ":uzytkownik_id", $_SESSION['user_id']);
        oci_execute($ocen);

        echo '<h1>Pomyslnie dodano ocene!</h1><br>';
    }
    else {
        if ($_POST['opinia']== "" OR $_POST['opinia']=="Podziel sie swoimi odczuciami na temat filmu") {
            $zmien_ocene = oci_parse($connection, "UPDATE ocena_filmu SET ocena = :ocena WHERE film_id = :film_id AND uzytkownik_id = :uzytkownik_id");
        }
        else {
            $zmien_ocene = oci_parse($connection, "UPDATE ocena_filmu SET ocena = :ocena, opinia = :opinia WHERE film_id = :film_id AND uzytkownik_id = :uzytkownik_id"); 
            oci_bind_by_name($zmien_ocene, ":opinia", $_POST['opinia']);  
        }
        oci_bind_by_name($zmien_ocene, ":film_id", $_POST['id_filmu']);
        oci_bind_by_name($zmien_ocene, ":ocena", $_POST['ocena']);
        oci_bind_by_name($zmien_ocene, ":uzytkownik_id", $_SESSION['user_id']);
        oci_execute($zmien_ocene);

        echo '<h1>Pomyslnie zaaktualizowano ocene!</h1><br>';
    }
    echo '<a href="ocen_film.php">Ocen kolejny film</a> lub <a href="home.php">wroc do strony glownej</a>';
    exit();

    oci_close($connection);
}
?>

<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Ocen film</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>
<h1>Ocen film</h1>
<form action='' method='post'>
ID filmu: <input type='number' name='id_filmu' min='1' max='4772'/><br>
Ocena: <input type='number' name='ocena' min='1' max='10'/><br>
Opinia:<br>
<textarea name='opinia'rows='5' cols='70'>
Podziel sie swoimi odczuciami na temat filmu</textarea><br>
<input type='Submit' value='Ocen'>
</form>
</body>
</html>