<?php include_once dirname(__DIR__) . '/config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Services</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="<?php echo BASE_URL; ?>" class="logo">
            <div class="logo-icon">
                <i data-lucide="home"></i>
            </div>
            HomeServ
        </a>

        <?php if (!isLoggedIn()): ?>
            <ul class="nav-links">
                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>services.php">Services</a></li>
                <li><a href="<?php echo BASE_URL; ?>about.php">About</a></li>
                <li><a href="<?php echo BASE_URL; ?>contact.php">Contact</a></li>
            </ul>
        <?php elseif ($_SESSION['role'] == 'user'): ?>
            <ul class="nav-links">
                <li><a href="<?php echo BASE_URL . 'user/index.php'; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>services.php">Browse Services</a></li>
                <li><a href="<?php echo BASE_URL; ?>user/bookings.php">My Bookings</a></li>
            </ul>
        <?php elseif ($_SESSION['role'] == 'provider'): ?>
            <ul class="nav-links">
                <li><a href="<?php echo BASE_URL . 'provider/index.php'; ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>provider/add-service.php">Add Service</a></li>
                <li><a href="<?php echo BASE_URL; ?>provider/bookings.php">Bookings</a></li>
            </ul>
        <?php elseif ($_SESSION['role'] == 'admin'): ?>
            <ul class="nav-links">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="providers.php">Providers</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="bookings.php">Bookings</a></li>
            </ul>
        <?php endif; ?>

        <div class="nav-actions">
            <?php if(isLoggedIn()): ?>
                <a href="<?php echo BASE_URL . ($_SESSION['role'] == 'user' ? 'user/profile.php' : ($_SESSION['role'] == 'provider' ? 'provider/profile.php' : 'admin/profile.php')); ?>" class="btn btn-ghost">
                    <i data-lucide="user" style="width:18px;height:18px"></i>
                    <?php echo $_SESSION['name']; ?>
                </a>
                <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-primary">Logout</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>login.php" class="btn btn-ghost">Login</a>
                <a href="<?php echo BASE_URL; ?>register.php" class="btn btn-primary">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        <?php showAlert(); ?>