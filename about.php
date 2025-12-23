<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section style="background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%); color: white; padding: 80px 0; margin-top: -24px;">
    <div class="container text-center">
        <h1 style="font-size: 3rem; margin-bottom: 16px;">
            <i data-lucide="info" style="width:48px;height:48px;margin-right:16px;"></i>
            About Us
        </h1>
        <p style="font-size: 1.25rem; color: var(--primary-100);">Learn more about Home Services</p>
    </div>
</section>

<!-- About Content -->
<section style="background: var(--secondary-50); padding: 80px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div>
                <img src="<?php echo BASE_URL; ?>assets/images/about-us.jpg" alt="About Us" style="width: 100%; height: 400px; object-fit: cover; border-radius: var(--radius-2xl); box-shadow: var(--shadow-2xl);" onerror="this.src='https://via.placeholder.com/500x400?text=Home+Services'">
            </div>
            <div>
                <h2 style="font-size: 2.5rem; margin-bottom: 16px;">Who We Are</h2>
                <p style="font-size: 1.125rem; color: var(--secondary-600); margin-bottom: 24px;">Your Trusted Home Services Platform</p>
                <p style="font-size: 1.0625rem; line-height: 1.7; margin-bottom: 20px;">
                    Home Services is a leading online platform that connects homeowners with verified and skilled service providers.
                    We understand the challenges of finding reliable professionals for home repairs and maintenance,
                    which is why we created this platform to make the process simple, transparent, and hassle-free.
                </p>
                <p style="font-size: 1.0625rem; line-height: 1.7;">
                    Whether you need a plumber, electrician, cleaner, painter, or carpenter,
                    we have a network of trusted professionals ready to help you with all your home service needs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission & Vision -->
<section style="background: white; padding: 80px 0;">
    <div class="container">
        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 32px;">
            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-200) 100%);">
                    <i data-lucide="target" style="width:32px;height:32px"></i>
                </div>
                <h3>Our Mission</h3>
                <p style="font-size: 1.0625rem; line-height: 1.7;">
                    To provide a seamless platform that connects customers with reliable
                    home service professionals, ensuring quality service delivery and
                    complete customer satisfaction.
                </p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-300) 0%, var(--accent-400) 100%); color: var(--accent-600);">
                    <i data-lucide="eye" style="width:32px;height:32px"></i>
                </div>
                <h3>Our Vision</h3>
                <p style="font-size: 1.0625rem; line-height: 1.7;">
                    To become the most trusted home services marketplace,
                    empowering service providers to grow their business while
                    making home maintenance easy for every homeowner.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section style="background: var(--secondary-50); padding: 80px 0;">
    <div class="container">
        <h2 class="section-title text-center">Why Choose Us?</h2>
        <p class="section-subtitle text-center">Discover what makes us the preferred choice for home services</p>

        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--success-100) 0%, #A7F3D0 100%); color: #059669;">
                    <i data-lucide="user-check" style="width:28px;height:28px"></i>
                </div>
                <h3>Verified Professionals</h3>
                <p>All our service providers are thoroughly verified and background checked for your safety.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-200) 100%);">
                    <i data-lucide="dollar-sign" style="width:28px;height:28px"></i>
                </div>
                <h3>Transparent Pricing</h3>
                <p>No hidden charges. See the price upfront before booking any service.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-300) 0%, var(--accent-400) 100%); color: var(--accent-600);">
                    <i data-lucide="clock" style="width:28px;height:28px"></i>
                </div>
                <h3>On-Time Service</h3>
                <p>Our professionals arrive on time and complete the work as scheduled.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--secondary-100) 0%, var(--secondary-200) 100%); color: var(--secondary-600);">
                    <i data-lucide="shield" style="width:28px;height:28px"></i>
                </div>
                <h3>Secure Booking</h3>
                <p>Your personal information and payments are completely secure with us.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-300) 0%, var(--accent-400) 100%); color: var(--accent-600);">
                    <i data-lucide="star" style="width:28px;height:28px"></i>
                </div>
                <h3>Quality Assurance</h3>
                <p>We ensure high-quality service delivery with our rating and review system.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--info-100) 0%, var(--info-200) 100%); color: var(--info-600);">
                    <i data-lucide="headphones" style="width:28px;height:28px"></i>
                </div>
                <h3>24/7 Support</h3>
                <p>Our customer support team is available round the clock to assist you.</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section style="background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%); color: white; padding: 80px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; text-align: center;">
            <?php
            // Get statistics from database
            $users_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'user'");
            $users_count = mysqli_fetch_assoc($users_query)['count'];

            $providers_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'provider'");
            $providers_count = mysqli_fetch_assoc($providers_query)['count'];

            $services_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM services");
            $services_count = mysqli_fetch_assoc($services_query)['count'];

            $bookings_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE status = 'completed'");
            $bookings_count = mysqli_fetch_assoc($bookings_query)['count'];
            ?>
            <div>
                <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 8px;"><?php echo $users_count; ?>+</h2>
                <p style="font-size: 1.125rem; color: var(--primary-100);">Happy Customers</p>
            </div>
            <div>
                <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 8px;"><?php echo $providers_count; ?>+</h2>
                <p style="font-size: 1.125rem; color: var(--primary-100);">Service Providers</p>
            </div>
            <div>
                <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 8px;"><?php echo $services_count; ?>+</h2>
                <p style="font-size: 1.125rem; color: var(--primary-100);">Services Available</p>
            </div>
            <div>
                <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 8px;"><?php echo $bookings_count; ?>+</h2>
                <p style="font-size: 1.125rem; color: var(--primary-100);">Jobs Completed</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section style="background: white; padding: 80px 0;">
    <div class="container text-center">
        <h2 style="font-size: 2.5rem; margin-bottom: 16px;">Ready to Get Started?</h2>
        <p style="font-size: 1.25rem; color: var(--secondary-600); margin-bottom: 32px;">Join thousands of satisfied customers today</p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo BASE_URL; ?>services.php" class="btn btn-primary btn-lg">
                <i data-lucide="search" style="width:20px;height:20px"></i>
                Browse Services
            </a>
            <a href="<?php echo BASE_URL; ?>register-provider.php" class="btn btn-outline btn-lg">
                <i data-lucide="user-plus" style="width:20px;height:20px"></i>
                Become a Provider
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
