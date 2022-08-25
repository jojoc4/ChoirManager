<?php

//DB
$dsn = 'mysql:dbname=DBNAME;host=HOST';
$user = 'USER';
$password = 'PASSWORD';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

//LOGIN
$USER_PASSWORD="USER PASSWORD";
$FORCE_HTTPS=true;