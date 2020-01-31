<?php
$mysqli = mysqli_connect("mysql", "root", "mayor", "parser");

if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
}

// $res = mysqli_query($mysqli, "SELECT * FROM text");
// $row = mysqli_fetch_assoc($res);
// print_r($row);
// die();
