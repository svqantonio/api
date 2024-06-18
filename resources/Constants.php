<?php
    $timer = 1500;

    $dbname = 'api';
    $servername = 'localhost';
    $username = 'root';
    $password = '';

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);