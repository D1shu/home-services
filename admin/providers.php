<?php 
include '../includes/header.php';
checkRole('admin');

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $provider_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE users SET status = 'active' WHERE id = $provider_id");
        $_SESSION['success'] = "Provider approved!";
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE users SET status = 'inactive' WHERE id = $provider_id");
    }
    redirect('admin/providers.php');
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'provider' ORDER BY created_at DESC");
?>

<h2><i class="fas fa-user-tie"></i> Manage Providers</h2>

<div class="table-responsive mt-4">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            while ($provider = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $provider['name']; ?></td>
                <td><?php echo $provider['email']; ?></td>
                <td><?php echo $provider['phone']; ?></td>
                <td><?php echo $provider['city']; ?></td>
                <td>
                    <span class="badge bg-<?php echo $provider['status'] == 'active' ? 'success' : ($provider['status'] == 'pending' ? 'warning' : 'danger'); ?>">
                        <?php echo ucfirst($provider['status']); ?>
                    </span>
                </td>
                <td><?php echo date('d M Y', strtotime($provider['created_at'])); ?></td>
                <td>
                    <?php if ($provider['status'] == 'pending'): ?>
                    <a href="?action=approve&id=<?php echo $provider['id']; ?>" class="btn btn-sm btn-success">Approve</a>
                    <a href="?action=reject&id=<?php echo $provider['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                    <?php elseif ($provider['status'] == 'active'): ?>
                    <a href="?action=reject&id=<?php echo $provider['id']; ?>" class="btn btn-sm btn-warning">Deactivate</a>
                    <?php else: ?>
                    <a href="?action=approve&id=<?php echo $provider['id']; ?>" class="btn btn-sm btn-success">Activate</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>