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

if (isset($_POST['id_filmu']) AND isset($_POST['akcja'])) {
    $connection = oci_connect($_SESSION['login'], $_SESSION['haslo'], null, 'AL32UTF8');
    if (!$connection) {
        $error = oci_error();
        echo "Blad w trakcie laczenia sie z baza! ({$error['message']})";
        exit();
    }

    $check_if_exists = oci_parse($connection, "SELECT pozycja FROM lista_do_obejrzenia WHERE uzytkownik_id = :id_uzytkownika AND id_filmu = :id_filmu");
    oci_bind_by_name($check_if_exists, ":id_uzytkownika", $_SESSION['user_id']);
    oci_bind_by_name($check_if_exists, ":id_filmu", $_POST['id_filmu']);
    oci_execute($check_if_exists);
    $rowCount = oci_fetch_all($check_if_exists, $check_if_existsAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

    if ($_POST['akcja']==dodaj) {
        if ($_POST['id_priorytetu']=="") {
            echo 'Nie podano parametru Priorytet. <a href="do_obejrzenia.php">Sprobuj ponownie</a>';
            exit();
        }

        if (!empty($check_if_existsAll)) {
            echo 'Podano zle parametry: dany film znajduje sie juz na liscie. <a href="do_obejrzenia.php">Sprobuj ponownie</a>';
            exit();
        }

        $dodaj = oci_parse($connection, "INSERT INTO pozycja (film_id, priorytet_id, uzytkownik_id) VALUES (:id_filmu, :id_priorytetu, :id_uzytkownika)");
        oci_bind_by_name($dodaj, ":id_uzytkownika", $_SESSION['user_id']);
        oci_bind_by_name($dodaj, ":id_filmu", $_POST['id_filmu']);
        oci_bind_by_name($dodaj, ":id_priorytetu", $_POST['id_priorytetu']);
        oci_execute($dodaj);
    }
    if ($_POST['akcja']==usun) {
        if (empty($check_if_existsAll)) {
            echo 'Podano zle parametry: dany film nie znajduje sie na liscie. <a href="do_obejrzenia.php">Sprobuj ponownie</a>';
            exit();
        }

        $usun = oci_parse($connection, "DELETE FROM pozycja WHERE uzytkownik_id = :id_uzytkownika AND film_id = :id_filmu");
        oci_bind_by_name($usun, ":id_uzytkownika", $_SESSION['user_id']);
        oci_bind_by_name($usun, ":id_filmu", $_POST['id_filmu']);
        oci_execute($usun);
    }

    oci_close($connection);
}
?>

<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Lista filmow do obejrzenia</title>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>
<h1>Twoja lista filmow do obejrzenia</h1>

<?php
$connection = oci_connect($_SESSION['login'], $_SESSION['haslo'], null, 'AL32UTF8');
if (!$connection) {
    $error = oci_error();
    echo "Blad w trakcie laczenia sie z baza! ({$error['message']})";
    exit();
}

$Lista = oci_parse($connection, "SELECT priorytet, id_filmu, tytul, rok_produkcji, gatunek, rezyser_imie, rezyser_nazwisko, czas_trwania, srednia_ocen FROM lista_do_obejrzenia
                                 WHERE uzytkownik_id = :id_uzytkownika");
oci_bind_by_name($Lista, ":id_uzytkownika", $_SESSION['user_id']);
oci_execute($Lista);
$rowCount = oci_fetch_all($Lista, $ListaAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
$colCount = oci_num_fields($Lista);
asort($Lista);

echo '<table width="100%">';
echo '<tr>';
for ($i = 1; $i <= $colCount; $i++) {
    echo '<th>' . oci_field_name($Lista, $i) . '</th>';
}
echo '</tr>';

foreach($ListaAll as $row) {
    echo '<tr>';
    foreach($row as $field) {
        echo '<td>' . $field . '</td>';
    }
    echo '</tr>';
}
echo '</table>';

oci_close($Lista);

echo '</hr>';
echo '<hr>';
?>


<form action='' method='post'>
<h2>Dodaj lub usun film z listy do obejrzenia<br></h2>
ID filmu: <input type='number' name='id_filmu' min='1' max='4772'/><br>
Dodaj/Usun:
<select name='akcja'>
<option value='dodaj'>Dodaj</option>
<option value='usun'>Usun</option>
</select><br>
Priorytet(dla dodaj): <input type='number' name='id_priorytetu' min='1' max='5'/><br>
<input type='Submit' value='Wykonaj'>
</form>
</hr>
</body>
</html>