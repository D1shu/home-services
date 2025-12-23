<?php 
include '../config/config.php';
checkRole('admin');

$admin_id = $_SESSION['user_id'];

// Get admin data
$query = "SELECT * FROM users WHERE id = $admin_id";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name = clean($_POST['name']);
    $phone = clean($_POST['phone']);
    
    $update_query = "UPDATE users SET name = '$name', phone = '$phone' WHERE id = $admin_id";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['name'] = $name;
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (password_verify($current_password, $admin['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $password_query = "UPDATE users SET password = '$hashed_password' WHERE id = $admin_id";
                
                if (mysqli_query($conn, $password_query)) {
                    $_SESSION['success'] = "Password changed successfully!";
                    header("Location: profile.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to change password.";
                }
            } else {
                $_SESSION['error'] = "Password must be at least 6 characters.";
            }
        } else {
            $_SESSION['error'] = "New passwords do not match.";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
    }
}

include '../includes/header.php';
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-shield"></i> Admin Profile</h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="row">
    
    <!-- Profile Information -->
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo $admin['name']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="<?php echo $admin['email']; ?>" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $admin['phone']; ?>">
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-dark">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Change Password -->
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-key"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="new_password" class="form-control" minlength="6" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                        </div>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-danger">
                        <i class="fas fa-lock"></i> Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px; font-size: 60px;">
                    <i class="fas fa-user-shield"></i>
                </div>
                
                <h4><?php echo $admin['name']; ?></h4>
                <span class="badge bg-dark mb-2">Administrator</span>
                <p class="text-muted"><i class="fas fa-envelope"></i> <?php echo $admin['email']; ?></p>
                
                <?php if (!empty($admin['phone'])): ?>
                    <p class="text-muted"><i class="fas fa-phone"></i> <?php echo $admin['phone']; ?></p>
                <?php endif; ?>
                
                <hr>
                
                <p class="mb-1"><strong>Account Created:</strong></p>
                <p class="text-muted"><?php echo date('d M Y', strtotime($admin['created_at'])); ?></p>
            </div>
        </div>
    </div>
    
</div>

<?php include '../includes/footer.php'; ?>