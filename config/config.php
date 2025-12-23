<?php
// Start session
session_start();

// Base URL
define('BASE_URL', 'http://localhost/home-services/');

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "home_services";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ============ FUNCTIONS ============

// Redirect function
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check user role
function checkRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] != $role) {
        redirect('login.php');
    }
}

// Sanitize input
function clean($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Display alert messages
function showAlert() {
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show">' . $_SESSION['success'] . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show">' . $_SESSION['error'] . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        unset($_SESSION['error']);
    }
}
?>