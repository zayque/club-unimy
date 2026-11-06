<?php
/////// Update your database login details here /////
$dbhost_name = getenv('DB_HOST') ?: "localhost"; // Your host name
$database    = getenv('DB_NAME') ?: "clubunimy"; // Your database name
$username    = getenv('DB_USER') ?: "root";      // Your login userid
$password    = getenv('DB_PASS') ?: "";          // Your password
//////// End of database details of your server //////

$conn = mysqli_connect($dbhost_name, $username, $password, $database);

if (!$conn) {
    http_response_code(500);
    echo "Unable to connect to the database. Check config-mysqli.php.";
    exit;
}
