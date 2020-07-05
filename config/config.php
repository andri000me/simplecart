<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_simplecart';
$db = new mysqli($host, $user, $pass, $db);
if ($db->connect_error) {
    die("Connection failed" . $db->connect_error);
}
