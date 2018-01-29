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
<title>Lista filmow</title>
</head>
<body>
<a href="home.php">Strona glowna</a><br>
<a href="login.php">Zaloguj sie</a><br>
<a href="lista_filmow.php">Lista filmow</a><br>
<hr>
<h1>Lista filmow</h1>

<?php
$connection = oci_connect($_SESSION['login'], $_SESSION['haslo'], null, 'AL32UTF8');
if (!$connection) {
    $error = oci_error();
    echo "Blad w trakcie laczenia sie z baza! ({$error['message']})";
    exit();
}

$Film = oci_parse($connection, "SELECT f.id AS ID, f.tytul AS TYTUL, f.rok_produkcji AS ROK_PRODUKCJI, g.nazwa AS GATUNEK, r.imie AS IMIE_REZYSERA,
                                       r.nazwisko AS NAZWISKO_REZYSERA, f.czas_trwania AS CZAS_TRWANIA, f.srednia_ocen AS OCENA
                                FROM film f LEFT JOIN gatunek g ON f.gatunek_id = g.id LEFT JOIN rezyser r ON f.rezyser_id = r.id");
oci_execute($Film);
$rowCount = oci_fetch_all($Film, $FilmAll, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
$colCount = oci_num_fields($Film);
asort($FilmAll);

echo "<table style=\"width:100%\">";
echo "<tr>";
for ($i = 1; $i <= $colCount; $i++) {
    echo "<th>" . oci_field_name($Film, $i) . "</th>";
}
echo "</tr>";

foreach($FilmAll as $row) {
    echo "<tr>";
    foreach($row as $field) {
        echo "<td>" . $field . "</td>";
    }
    echo "</tr>";
}

oci_close($Film);
?>

</hr>
</body>
</html>