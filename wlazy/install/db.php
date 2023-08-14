<?php
session_start();
$DB_NAME = $_POST['db_name'];
$DB_USER = $_POST['db_username'];
$DB_PASSWORD = $_POST['db_password'];
$DB_HOST = $_POST['db_host'];
$DB_PORT = $_POST['db_port'];
header('Content-Type: application/json');
try {
    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, $DB_PORT);
    if ($mysqli->connect_errno) {
        http_response_code(500);
        echo json_encode(array('message' => 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error));
        return;
    } else {
        http_response_code(200);
        $_SESSION['db_name'] = $DB_NAME;
        $_SESSION['db_username'] = $DB_USER;
        $_SESSION['db_password'] = $DB_PASSWORD;
        $_SESSION['db_host'] = $DB_HOST;
        $_SESSION['db_port'] = $DB_PORT;
        $_SESSION['db'] = true;
        echo json_encode(array('message' => 'Connected to MySQL: (' . $mysqli->host_info . ') ' . $mysqli->server_info));
        return;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Failed to connect to MySQL: (' . $e->getMessage() . ') '));
    return;
}
