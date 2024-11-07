<?php
    $host='localhost';
    $username='GA_Manager';
    $password='123';
    $database='greenantz_db';

    $conn = mysqli_connect($host,$username,$password,$database);
    
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL:". mysqli_connect_error();
    }
?>