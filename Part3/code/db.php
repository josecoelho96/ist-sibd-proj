<?php
    $host = 'db.tecnico.ulisboa.pt';
    $user = 'ist181013';
    $pass = 'yqro6990';

    $dsn = "mysql:host=$host;dbname=$user";
    
    try {
        return new PDO($dsn, $user, $pass);                        
    } catch(PDOException $ex) {
        echo("<p>ERROR: " . $ex->getMessage() . "</p>");
        exit();
    }