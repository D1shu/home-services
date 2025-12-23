<?php
include 'config/config.php';

// Handle Registration
if (isset($_POST['register'])) {
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $phone = clean($_POST['phone']);
    $address = clean($_POST['address']);
    $city = clean($_POST['city']);
    $role = clean($_POST['role']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if ($password != $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        redirect('register.php');
    }

    // Validate role
    if (!in_array($role, ['user', 'provider'])) {
        $_SESSION['error'] = "Invalid role selected!";
        redirect('register.php');
    }

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email already registered!";
        redirect('register.php');
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $query = "INSERT INTO users (name, email, phone, address, city, password, role, status)
              VALUES ('$name', '$email', '$phone', '$address', '$city', '$hashed_password', '$role', 'active')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Registration successful! Please login.";
        redirect('login.php');
    } else {
        $_SESSION['error'] = "Registration failed. Try again.";
        redirect('register.php');
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> User Registration</h4>
            </div>
            <div class="card-body">
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">I want to register as:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="role_user" value="user" checked>
                            <label class="form-check-label" for="role_user">
                                User (Book services)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="role_provider" value="provider">
                            <label class="form-check-label" for="role_provider">
                                Service Provider (Offer services)
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                </form>
                <p class="mt-3 text-center">
                    Already have an account? <a href="login.php">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
