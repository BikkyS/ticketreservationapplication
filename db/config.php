<?php
define('DB_SERVER','db');
define('DB_USERNAME','root');
define('DB_PASSWORD','example');
define('DB_NAME','registration');

// connecting

$conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

//check connection
if(!$conn){
    echo('Error: cannot connect');
}
?>