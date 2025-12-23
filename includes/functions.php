<?php

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
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
}
?>