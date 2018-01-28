<html>
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8'>
<title>Home</title>
</head>
<body>
<h1>Home</h1>

<?php
session_start();
if (!($_SESSION['logged_in']==true)) {
    echo "Odmowa dostepu. Musisz sie najpierw zalogowac.<br>";
    exit();
}
?>

</body>
</html>