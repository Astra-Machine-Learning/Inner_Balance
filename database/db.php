<?php



$db_server = "localhost";
$db_user = "root";
$db_pass = '22092209';
$db_name = 'innerpeace';
$conn = null;

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    
    if (!$conn) {
        throw new Exception("Could not connect to the database");
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    exit("Database connection error. Please try again later.");
}

?>
