<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Home</title>
</head>
<body>
<h1>Home</h1>

<?php
session_start();
if ($_SESSION['logged_in']==true OR ($_POST['login']=="jw386401" AND $_POST['haslo']=="qwerty")) {
    $_SESSION['logged_in']=true;
    $_SESSION['login']="jw386401";
    $_SESSION['haslo']="qwerty";
    echo "Zostales poprawnie zalogowany!<br>";
}
else {
    echo "Odmowa dostepu. Musisz sie najpierw zalogowac.<br>";
    exit();
}

echo "<br>tutaj bedą jakieś dalsze linki<br>";
?>

</body>
</html>