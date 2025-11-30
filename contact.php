<?php
require_once 'config.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Here you would typically send an email or save to database
        // For now, we'll just show a success message
        $success = 'Thank you for contacting us! We\'ll get back to you within 24 hours.';
        
        // Clear form
        $name = $email = $subject = $message = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .contact-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .contact-header h1 {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .contact-header p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .contact-info-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .contact-info-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 25px;
        }

        .contact-method {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%);
            border-radius: 12px;
            margin-bottom: 20px;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .contact-method:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.15);
        }

        .contact-icon {
            font-size: 2rem;
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-details h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .contact-details p {
            color: var(--text-light);
            margin: 0;
            line-height: 1.6;
        }

        .contact-details a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .contact-details a:hover {
            text-decoration: underline;
        }

        .contact-form-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .contact-form-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            font-family: inherit;
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(124, 58, 237, 0.4);
        }

        .social-connect {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            color: white;
        }

        .social-connect h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .social-connect p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: white;
            color: var(--primary);
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.8rem;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .social-link:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .business-hours {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            padding: 30px;
            border-radius: 16px;
            margin-top: 30px;
        }

        .business-hours h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .hours-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(124, 58, 237, 0.1);
        }

        .hours-row:last-child {
            border-bottom: none;
        }

        .day {
            font-weight: 700;
            color: var(--dark);
        }

        .time {
            color: var(--text-light);
            font-weight: 600;
        }

        .map-section {
            margin-top: 60px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .map-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 25px;
            text-align: center;
        }

        .map-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            font-size: 3rem;
        }

        @media (max-width: 968px) {
            .contact-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .contact-header h1 {
                font-size: 2.2rem;
            }

            .contact-info-section,
            .contact-form-section {
                padding: 30px 25px;
            }

            .social-connect {
                padding: 40px 25px;
            }
        }

        @media (max-width: 480px) {
            .contact-header h1 {
                font-size: 1.8rem;
            }

            .contact-method {
                flex-direction: column;
                text-align: center;
            }

            .contact-icon {
                margin: 0 auto;
            }

            .map-placeholder {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="contact-container">
        <div class="contact-header">
            <h1>Get In Touch</h1>
            <p>Have a question or need assistance? We're here to help! Reach out to us through any of the methods below.</p>
        </div>

        <div class="contact-content">
            <div class="contact-info-section">
                <h2>Contact Information</h2>
                
                <div class="contact-method">
                    <div class="contact-icon">📧</div>
                    <div class="contact-details">
                        <h3>Email Us</h3>
                        <p>General Inquiries:<br>
                        <a href="mailto:support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com">support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a></p>
                        <p>Customer Support:<br>
                        <a href="mailto:help@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com">help@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a></p>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">📞</div>
                    <div class="contact-details">
                        <h3>Call Us</h3>
                        <p>Customer Service:<br>
                        <a href="tel:+639123456789">+63 912 345 6789</a></p>
                        <p>Business Hours:<br>
                        Mon-Fri: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">💬</div>
                    <div class="contact-details">
                        <h3>Live Chat</h3>
                        <p>Chat with our support team<br>
                        Available 24/7 for instant help</p>
                        <a href="#" style="margin-top: 10px; display: inline-block;">Start Chat →</a>
                    </div>
                </div>

                <div class="contact-method">
                    <div class="contact-icon">📍</div>
                    <div class="contact-details">
                        <h3>Visit Us</h3>
                        <p>123 Commerce Street<br>
                        Quezon City, Metro Manila<br>
                        Philippines, 1100</p>
                    </div>
                </div>

                <div class="business-hours">
                    <h3>Business Hours</h3>
                    <div class="hours-row">
                        <span class="day">Monday - Friday</span>
                        <span class="time">9:00 AM - 6:00 PM</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Saturday</span>
                        <span class="time">10:00 AM - 4:00 PM</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Sunday</span>
                        <span class="time">Closed</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Public Holidays</span>
                        <span class="time">Closed</span>
                    </div>
                </div>
            </div>

            <div class="contact-form-section">
                <h2>Send Us a Message</h2>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <span class="alert-icon">✓</span>
                        <div class="alert-content"><?php echo htmlspecialchars($success); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <span class="alert-icon">✕</span>
                        <div class="alert-content"><?php echo htmlspecialchars($error); ?></div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required 
                               placeholder="Enter your full name"
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required 
                               placeholder="your.email@example.com"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Order Status">Order Status</option>
                            <option value="Product Question">Product Question</option>
                            <option value="Shipping Issue">Shipping Issue</option>
                            <option value="Return Request">Return Request</option>
                            <option value="Payment Issue">Payment Issue</option>
                            <option value="Technical Support">Technical Support</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Partnership">Partnership Inquiry</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required 
                                  placeholder="Tell us how we can help you..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>

        <div class="social-connect">
            <h2>Connect With Us</h2>
            <p>Follow us on social media for the latest updates, promotions, and exclusive offers!</p>
            <div class="social-links">
                <a href="#" class="social-link" title="Facebook">📘</a>
                <a href="#" class="social-link" title="Twitter">🐦</a>
                <a href="#" class="social-link" title="Instagram">📷</a>
                <a href="#" class="social-link" title="LinkedIn">💼</a>
                <a href="#" class="social-link" title="YouTube">📺</a>
                <a href="#" class="social-link" title="TikTok">🎵</a>
            </div>
        </div>

        <div class="map-section">
            <h2>Find Us Here</h2>
            <div class="map-placeholder">
                📍 Map Location
            </div>
            <p style="text-align: center; margin-top: 20px; color: var(--text-light);">
                <strong>Address:</strong> 123 Commerce Street, Quezon City, Metro Manila, Philippines 1100
            </p>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>