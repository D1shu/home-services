<?php include 'includes/header.php'; ?>

<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login</h4>
            </div>
            <div class="card-body">
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="mt-3 text-center">
                    Don't have an account? <a href="register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
// Handle Login
if (isset($_POST['login'])) {
    $email = clean($_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            if ($user['status'] == 'active') {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect based on role
                if ($user['role'] == 'admin') {
                    redirect('admin/index.php');
                } elseif ($user['role'] == 'provider') {
                    redirect('provider/index.php');
                } else {
                    redirect('user/index.php');
                }
            } else {
                $_SESSION['error'] = "Your account is not active.";
                redirect('login.php');
            }
        } else {
            $_SESSION['error'] = "Invalid password!";
            redirect('login.php');
        }
    } else {
        $_SESSION['error'] = "Email not found!";
        redirect('login.php');
    }
}
?>

<?php include 'includes/footer.php'; ?>