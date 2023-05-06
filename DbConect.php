<?php

$con = mysqli_connect("localhost", "root", "");
if ($con->connect_error) {
    die("Failed Connection with Database" . $con->connect_error);
}

$db_selected = mysqli_select_db($con, 'onlineshoppingcart');
if (!$db_selected) {
    // If we couldn't, then it either doesn't exist, or we can't see it.
    $sql = 'CREATE DATABASE onlineshoppingcart';

    if (mysqli_query($con, $sql)) {
        echo "Database onlineshoppingcart created successfully\n";
    } else {
        echo 'Error creating database: ' . mysql_error() . "\n";
    }
} else {
    $con = mysqli_connect("localhost", "root", "", "onlineshoppingcart");
    if ($con->connect_error) {
        die("Failed Connection with Database" . $con->connect_error);
    }
}
include_once 'tables.php';
?>
