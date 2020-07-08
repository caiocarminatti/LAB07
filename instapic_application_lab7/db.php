<?php
    $dsn = 'mysql:host=172.31.22.43;dbname=Caio200437139';
    $usrname = 'Caio200437139';
    $pword = 'y2wKC7fO6t';
    $conn = new PDO($dsn, $usrname, $pword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
