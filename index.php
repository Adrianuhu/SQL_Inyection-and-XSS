<?php

$dbValue = '';
$dbValueProtected = '';
$script = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user']) && $_POST['user'] != "") {
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'hackme');
    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    mysqli_set_charset($connection, "utf8");
    
    $user = $_POST['user'];
    // Securice
    $user=mysqli_real_escape_string($connection, $user);
    $query=mysqli_query($connection, "SELECT name, description FROM users WHERE name like '$user'");
    if (mysqli_num_rows($query) > 0 ) {
        $ins = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
        $dbValue = $ins['name'] . $ins['description'];
    }else {
        $dbValue = "ERROR";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['script']) && $_POST['script'] != "") {    
    $script = "<script>" . $_POST['script'] . "</script>";
    // Securice
    // $script = htmlspecialchars($script);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['scriptFunction']) && $_POST['scriptFunction'] != "") {    
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'hackme');
    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    mysqli_set_charset($connection, "utf8");
    
    $scriptFunction = $_POST['scriptFunction'];
    $scriptFunction=mysqli_real_escape_string($connection, $_POST['scriptFunction']);
    $query=mysqli_query($connection, "update `users` set description = '$scriptFunction' where name like 'user2'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <!-- Inyection:     ' or ''='        -->
        <p>Regular Query: <span style="background-color:yellow"> user1 </span></p>
        <p>SQL Inyection: <span style="background-color:yellow"> ' or ''=' </span></p>
        <input type="text" name="user" id="user" placeholder="user">
        <input type="submit" value="GO">
        <p id="dbValue">Result: <?=$dbValue?></p>
        <hr>
        <!-- Cross Site Scripting -->
        <p>Cross Site Scripting</p>
        <input type="text" name="script" id="script" placeholder="alert('hacked')">
        <input type="submit" value="GO">
        <p id="dbValue">Script: <?=$script?></p>
        <hr>
        <!-- Cross Site Scripting Insert -->
        <input type="text" name="scriptFunction" id="script" placeholder="<script>">
        <input type="submit" value="GO">

    </form>


    
</body>
</html>