<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Join Our <span>Team</span></h1>
            <p>Build the future of home services with passionate individuals like you.</p>
        </div>
    </div>
</section>

<!-- Why Join Section -->
<section style="background: white;">
    <div class="container">
        <h2 class="section-title text-center">Why Join HomeServ?</h2>
        <p class="section-subtitle text-center">We're looking for passionate individuals to help us revolutionize home services</p>

        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-200) 100%);">
                    <i data-lucide="users" style="width:32px;height:32px"></i>
                </div>
                <h3>Growth Opportunities</h3>
                <p>Continuous learning and career advancement in a growing industry.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-300) 0%, var(--accent-400) 100%); color: var(--accent-600);">
                    <i data-lucide="heart" style="width:32px;height:32px"></i>
                </div>
                <h3>Work-Life Balance</h3>
                <p>Flexible schedules and remote work options available.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--success-100) 0%, #A7F3D0 100%); color: #059669;">
                    <i data-lucide="award" style="width:32px;height:32px"></i>
                </div>
                <h3>Competitive Benefits</h3>
                <p>Health insurance, paid time off, and performance bonuses.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Initialize Lucide Icons -->
<script>
    lucide.createIcons();
</script>
