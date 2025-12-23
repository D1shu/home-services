<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<section class="bg-primary text-white py-5 mb-4" style="margin-top: -24px;">
    <div class="container text-center">
        <h1><i class="fas fa-envelope"></i> Contact Us</h1>
        <p class="lead">We'd love to hear from you</p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            
            <!-- Contact Form -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0"><i class="fas fa-paper-plane text-primary"></i> Send us a Message</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        // Handle form submission
                        if (isset($_POST['send_message'])) {
                            $name = clean($_POST['name']);
                            $email = clean($_POST['email']);
                            $phone = clean($_POST['phone']);
                            $subject = clean($_POST['subject']);
                            $message = clean($_POST['message']);
                            
                            // You can save to database or send email here
                            // For now, just show success message
                            
                            if (!empty($name) && !empty($email) && !empty($message)) {
                                $_SESSION['success'] = "Thank you for contacting us! We will get back to you soon.";
                                echo '<script>window.location.href = "contact.php";</script>';
                            } else {
                                $_SESSION['error'] = "Please fill in all required fields.";
                                echo '<script>window.location.href = "contact.php";</script>';
                            }
                        }
                        ?>
                        
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                                    <select name="subject" class="form-select" required>
                                        <option value="">Select Subject</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Booking Issue">Booking Issue</option>
                                        <option value="Payment Issue">Payment Issue</option>
                                        <option value="Provider Registration">Provider Registration</option>
                                        <option value="Complaint">Complaint</option>
                                        <option value="Feedback">Feedback</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Your Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <button type="submit" name="send_message" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-md-4">
                
                <!-- Contact Details Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-address-card text-primary"></i> Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Address</h6>
                                <p class="text-muted mb-0">123 Main Street<br>City, State - 123456</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-phone fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Phone</h6>
                                <p class="text-muted mb-0">+91 9876543210<br>+91 1234567890</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Email</h6>
                                <p class="text-muted mb-0">info@homeservices.com<br>support@homeservices.com</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Working Hours</h6>
                                <p class="text-muted mb-0">Mon - Sat: 9:00 AM - 8:00 PM<br>Sunday: 10:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-share-alt text-primary"></i> Follow Us</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="#" class="btn btn-outline-primary btn-lg me-2 mb-2">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-info btn-lg me-2 mb-2">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-danger btn-lg me-2 mb-2">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-lg me-2 mb-2">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="btn btn-outline-success btn-lg mb-2">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- Google Map Section (Optional) -->
<section class="py-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-map text-primary"></i> Find Us on Map</h5>
            </div>
            <div class="card-body p-0">
                <!-- Replace with your actual Google Maps embed code -->
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0977479040455!2d-122.41941548468258!3d37.77492977975892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2sin!4v1234567890" 
                    width="100%" 
                    height="350" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">Frequently Asked Questions</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion" id="faqAccordion">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I book a service?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Simply browse our services, select the one you need, choose your preferred date and time, 
                                and confirm your booking. You'll receive a confirmation once a provider accepts your request.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How are service providers verified?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                All service providers go through a thorough verification process including ID verification, 
                                background checks, and skill assessment before they can offer services on our platform.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Can I cancel my booking?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, you can cancel your booking from your dashboard. However, please try to cancel 
                                at least 2 hours before the scheduled time to avoid any cancellation charges.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How can I become a service provider?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Click on "Register as Provider" and fill in your details. Our team will verify your 
                                information and approve your account. Once approved, you can start listing your services.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                What payment methods are accepted?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept various payment methods including cash on service completion, 
                                UPI payments, debit/credit cards, and net banking.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>