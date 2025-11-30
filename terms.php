<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .legal-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .legal-header {
            text-align: center;
            margin-bottom: 50px;
            padding-bottom: 30px;
            border-bottom: 3px solid var(--primary);
        }

        .legal-header h1 {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .last-updated {
            color: var(--text-light);
            font-size: 1rem;
            font-weight: 600;
        }

        .legal-content {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            line-height: 1.8;
        }

        .legal-content h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin: 40px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
        }

        .legal-content h2:first-child {
            margin-top: 0;
        }

        .legal-content h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin: 30px 0 15px;
        }

        .legal-content p {
            color: var(--text);
            margin-bottom: 15px;
            text-align: justify;
        }

        .legal-content ul,
        .legal-content ol {
            margin: 20px 0;
            padding-left: 30px;
            color: var(--text);
        }

        .legal-content li {
            margin-bottom: 12px;
            line-height: 1.8;
        }

        .legal-content strong {
            color: var(--dark);
            font-weight: 700;
        }

        .highlight-box {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--primary);
            margin: 25px 0;
        }

        .contact-box {
            background: var(--light);
            padding: 30px;
            border-radius: 16px;
            margin-top: 40px;
            text-align: center;
        }

        .contact-box h3 {
            color: var(--dark);
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .contact-box p {
            margin-bottom: 10px;
        }

        .contact-box a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .contact-box a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .legal-content {
                padding: 30px 25px;
            }

            .legal-header h1 {
                font-size: 2.2rem;
            }

            .legal-content h2 {
                font-size: 1.6rem;
            }

            .legal-content h3 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .legal-header h1 {
                font-size: 1.8rem;
            }

            .legal-content {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="legal-container">
        <div class="legal-header">
            <h1>Terms of Service</h1>
            <p class="last-updated">Last Updated: <?php echo date('F d, Y'); ?></p>
        </div>
        
        <div class="legal-content">
            <div class="highlight-box">
                <p><strong>Welcome to <?php echo SITE_NAME; ?>!</strong> By accessing or using our website and services, you agree to be bound by these Terms of Service. Please read them carefully before making any purchase or using our services.</p>
            </div>

            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using <?php echo SITE_NAME; ?> (the "Website"), you accept and agree to be bound by the terms and provisions of this agreement. If you do not agree to these terms, please do not use our services.</p>

            <h2>2. Eligibility</h2>
            <p>To use our services, you must:</p>
            <ul>
                <li>Be at least 18 years of age or have parental/guardian consent</li>
                <li>Have the legal capacity to enter into binding contracts</li>
                <li>Not be prohibited from using our services under applicable laws</li>
                <li>Provide accurate, current, and complete information during registration</li>
            </ul>

            <h2>3. User Accounts</h2>
            <h3>3.1 Account Creation</h3>
            <p>When you create an account with us, you must provide information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms.</p>

            <h3>3.2 Account Security</h3>
            <p>You are responsible for:</p>
            <ul>
                <li>Maintaining the confidentiality of your account and password</li>
                <li>Restricting access to your computer and account</li>
                <li>All activities that occur under your account</li>
                <li>Notifying us immediately of any unauthorized use</li>
            </ul>

            <h2>4. Products and Services</h2>
            <h3>4.1 Product Information</h3>
            <p>We strive to provide accurate product descriptions, images, and pricing. However, we do not warrant that product descriptions, colors, information, or other content available on the Website is accurate, complete, reliable, current, or error-free.</p>

            <h3>4.2 Pricing</h3>
            <ul>
                <li>All prices are displayed in Philippine Peso (PHP) unless otherwise stated</li>
                <li>Prices are subject to change without notice</li>
                <li>We reserve the right to modify or discontinue products at any time</li>
                <li>Special offers and promotions are subject to availability and terms</li>
            </ul>

            <h3>4.3 Product Availability</h3>
            <p>We make every effort to display available products. However, we cannot guarantee that products will always be in stock. We reserve the right to limit quantities or refuse orders at our discretion.</p>

            <h2>5. Orders and Payments</h2>
            <h3>5.1 Order Acceptance</h3>
            <p>Your receipt of an order confirmation does not signify our acceptance of your order. We reserve the right to accept or decline your order for any reason, including but not limited to:</p>
            <ul>
                <li>Product availability</li>
                <li>Errors in product or pricing information</li>
                <li>Suspected fraudulent activity</li>
                <li>Problems identified by our credit or fraud screening systems</li>
            </ul>

            <h3>5.2 Payment Methods</h3>
            <p>We accept the following payment methods:</p>
            <ul>
                <li>Credit/Debit Cards (Visa, Mastercard, American Express)</li>
                <li>PayPal</li>
                <li>GCash</li>
                <li>Cash on Delivery (COD)</li>
            </ul>

            <h3>5.3 Payment Security</h3>
            <p>All payment transactions are encrypted and processed through secure payment gateways. We do not store complete credit card information on our servers.</p>

            <h2>6. Shipping and Delivery</h2>
            <h3>6.1 Shipping Policy</h3>
            <ul>
                <li>Standard shipping: 5-7 business days</li>
                <li>Express shipping: 2-3 business days</li>
                <li>Free shipping on orders over ₱2,000</li>
                <li>Shipping times may vary based on location and product availability</li>
            </ul>

            <h3>6.2 Delivery</h3>
            <p>You are responsible for providing accurate delivery information. We are not liable for delivery delays caused by incorrect addresses or unavailability at the delivery location.</p>

            <h2>7. Returns and Refunds</h2>
            <h3>7.1 Return Policy</h3>
            <p>We offer a 30-day return policy on most products. To be eligible for a return:</p>
            <ul>
                <li>Item must be unused and in the same condition as received</li>
                <li>Item must be in original packaging</li>
                <li>Proof of purchase must be provided</li>
                <li>Return request must be initiated within 30 days of delivery</li>
            </ul>

            <h3>7.2 Non-Returnable Items</h3>
            <p>Certain items cannot be returned, including:</p>
            <ul>
                <li>Personalized or custom-made products</li>
                <li>Perishable goods</li>
                <li>Intimate or sanitary products</li>
                <li>Digital products and downloads</li>
            </ul>

            <h3>7.3 Refunds</h3>
            <p>Once your return is received and inspected, we will send you an email notification. If approved, your refund will be processed within 7-10 business days to your original payment method.</p>

            <h2>8. Intellectual Property Rights</h2>
            <p>The Website and its entire contents, features, and functionality are owned by <?php echo SITE_NAME; ?> and are protected by international copyright, trademark, and other intellectual property laws.</p>
            <p>You may not:</p>
            <ul>
                <li>Reproduce, distribute, or create derivative works from our content</li>
                <li>Use our trademarks, logos, or brand names without permission</li>
                <li>Copy or scrape product information, images, or descriptions</li>
                <li>Use automated systems to access our Website</li>
            </ul>

            <h2>9. Prohibited Activities</h2>
            <p>You agree not to engage in any of the following prohibited activities:</p>
            <ul>
                <li>Using the Website for any illegal purpose</li>
                <li>Attempting to gain unauthorized access to our systems</li>
                <li>Interfering with the proper functioning of the Website</li>
                <li>Transmitting viruses, malware, or harmful code</li>
                <li>Harassing, threatening, or impersonating others</li>
                <li>Posting false, misleading, or fraudulent information</li>
                <li>Violating any applicable laws or regulations</li>
            </ul>

            <h2>10. User Content</h2>
            <h3>10.1 Reviews and Comments</h3>
            <p>Users may post reviews, comments, and other content. By posting content, you grant us a non-exclusive, worldwide, royalty-free license to use, reproduce, and display such content.</p>

            <h3>10.2 Content Standards</h3>
            <p>User content must not:</p>
            <ul>
                <li>Contain false or misleading information</li>
                <li>Be defamatory, obscene, or offensive</li>
                <li>Infringe on intellectual property rights</li>
                <li>Contain promotional or commercial content</li>
                <li>Violate any laws or regulations</li>
            </ul>

            <h2>11. Limitation of Liability</h2>
            <p>To the fullest extent permitted by law, <?php echo SITE_NAME; ?> shall not be liable for:</p>
            <ul>
                <li>Indirect, incidental, special, or consequential damages</li>
                <li>Loss of profits, revenue, data, or use</li>
                <li>Damages resulting from unauthorized access to your account</li>
                <li>Delays or failures in performance beyond our control</li>
            </ul>
            <p>Our total liability shall not exceed the amount paid by you for the product or service in question.</p>

            <h2>12. Indemnification</h2>
            <p>You agree to indemnify and hold harmless <?php echo SITE_NAME; ?>, its affiliates, officers, directors, and employees from any claims, damages, losses, liabilities, and expenses arising from:</p>
            <ul>
                <li>Your use of the Website</li>
                <li>Your violation of these Terms</li>
                <li>Your violation of any rights of another party</li>
                <li>Your content posted on the Website</li>
            </ul>

            <h2>13. Privacy</h2>
            <p>Your use of the Website is also governed by our Privacy Policy. Please review our <a href="privacy.php" style="color: var(--primary); font-weight: 700;">Privacy Policy</a> to understand our practices.</p>

            <h2>14. Modifications to Terms</h2>
            <p>We reserve the right to modify these Terms at any time. We will notify users of any material changes by:</p>
            <ul>
                <li>Posting the updated Terms on the Website</li>
                <li>Updating the "Last Updated" date</li>
                <li>Sending email notifications for significant changes</li>
            </ul>
            <p>Your continued use of the Website after changes constitutes acceptance of the modified Terms.</p>

            <h2>15. Governing Law</h2>
            <p>These Terms shall be governed by and construed in accordance with the laws of the Republic of the Philippines, without regard to its conflict of law provisions.</p>

            <h2>16. Dispute Resolution</h2>
            <h3>16.1 Informal Resolution</h3>
            <p>In the event of any dispute, we encourage you to contact us first to seek an informal resolution.</p>

            <h3>16.2 Arbitration</h3>
            <p>If informal resolution is unsuccessful, disputes shall be resolved through binding arbitration in accordance with Philippine law.</p>

            <h2>17. Severability</h2>
            <p>If any provision of these Terms is found to be unenforceable or invalid, that provision will be limited or eliminated to the minimum extent necessary, and the remaining provisions will remain in full force and effect.</p>

            <h2>18. Entire Agreement</h2>
            <p>These Terms constitute the entire agreement between you and <?php echo SITE_NAME; ?> regarding the use of the Website and supersede all prior agreements and understandings.</p>

            <h2>19. Waiver</h2>
            <p>No waiver of any term of these Terms shall be deemed a further or continuing waiver of such term or any other term.</p>

            <h2>20. Contact Information</h2>
            <div class="contact-box">
                <h3>Questions About Our Terms?</h3>
                <p>If you have any questions about these Terms of Service, please contact us:</p>
                <p><strong>Email:</strong> <a href="mailto:legal@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com">legal@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a></p>
                <p><strong>Phone:</strong> <a href="tel:+639123456789">+63 912 345 6789</a></p>
                <p><strong>Address:</strong> Quezon City, Metro Manila, Philippines</p>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>