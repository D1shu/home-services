<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-user-tie"></i> Provider Registration</h4>
            </div>
            <div class="card-body">
                <form action="register-provider.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" name="register_provider" class="btn btn-success w-100">Register as Provider</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['register_provider'])) {
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $phone = clean($_POST['phone']);
    $address = clean($_POST['address']);
    $city = clean($_POST['city']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password != $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        redirect('register-provider.php');
    }
    
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email already registered!";
        redirect('register-provider.php');
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Provider status is 'pending' until admin approves
    $query = "INSERT INTO users (name, email, phone, address, city, password, role, status) 
              VALUES ('$name', '$email', '$phone', '$address', '$city', '$hashed_password', 'provider', 'pending')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Registration successful! Please wait for admin approval.";
        redirect('login.php');
    } else {
        $_SESSION['error'] = "Registration failed. Try again.";
        redirect('register-provider.php');
    }
}
?>

<?php include 'includes/footer.php'; ?>