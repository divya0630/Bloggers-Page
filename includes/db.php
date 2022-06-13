<?php

$DB_HOST="localhost";
$DB_USERNAME="root";
$DB_PASSWORD="";
$DB_NAME="cms";

$connect = mysqli_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);

if(!$connect)
    echo "Error in connecting to database!";
?>