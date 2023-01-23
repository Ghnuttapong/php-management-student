<?php
$dns = 'mysql:host=localhost;dbname=ry_school';
$username = 'root';
$password = '';

// Create connection
try {
  $obj = new PDO($dns, $username, $password);
  $obj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $obj->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $e->getMessage();
}
