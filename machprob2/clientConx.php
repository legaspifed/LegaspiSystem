<?php
    $host='localhost';
    $username='client';
    $password='123';
    $database='machprob2';

    $conn = mysqli_connect($host,$username,$password,$database);
    
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL:". mysqli_connect_error();
    }
?> 