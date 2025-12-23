<?php 
include '../includes/header.php';
checkRole('admin');

// Handle status update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'activate') {
        mysqli_query($conn, "UPDATE users SET status = 'active' WHERE id = $user_id");
    } elseif ($action == 'deactivate') {
        mysqli_query($conn, "UPDATE users SET status = 'inactive' WHERE id = $user_id");
    } elseif ($action == 'delete') {
        mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
    }
    redirect('admin/users.php');
}

$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user' ORDER BY created_at DESC");
?>

<h2><i class="fas fa-users"></i> Manage Users</h2>

<div class="table-responsive mt-4">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            while ($user = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td>
                    <span class="badge bg-<?php echo $user['status'] == 'active' ? 'success' : 'danger'; ?>">
                        <?php echo ucfirst($user['status']); ?>
                    </span>
                </td>
                <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                <td>
                    <?php if ($user['status'] == 'active'): ?>
                    <a href="?action=deactivate&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">Deactivate</a>
                    <?php else: ?>
                    <a href="?action=activate&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-success">Activate</a>
                    <?php endif; ?>
                    <a href="?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>