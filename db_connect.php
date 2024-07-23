<?php
    const SERVER = 'mysql301.phy.lolipop.lan';
    const DBNAME = 'LAA1517815-ch';
    const USER = 'LAA1517815';
    const PASS = 'chinese';
    $pdo = new PDO('mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8', USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>