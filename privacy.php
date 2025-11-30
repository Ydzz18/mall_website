<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - <?php echo SITE_NAME; ?></title>
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

        .info-box {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--info);
            margin: 25px 0;
        }

        .warning-box {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--warning);
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

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .data-table th {
            background: var(--primary);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 700;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
        }

        .data-table tr:last-child td {
            border-bottom: none;
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

            .data-table {
                font-size: 0.9rem;
            }

            .data-table th,
            .data-table td {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .legal-header h1 {
                font-size: 1.8rem;
            }

            .legal-content {
                padding: 25px 20px;
            }

            .data-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="legal-container">
        <div class="legal-header">
            <h1>Privacy Policy</h1>
            <p class="last-updated">Last Updated: <?php echo date('F d, Y'); ?></p>
        </div>
        
        <div class="legal-content">
            <div class="highlight-box">
                <p><strong>Your Privacy Matters to Us.</strong> At <?php echo SITE_NAME; ?>, we are committed to protecting your personal information and your right to privacy. This Privacy Policy explains what information we collect, how we use it, and what rights you have in relation to it.</p>
            </div>

            <h2>1. Information We Collect</h2>
            <p>We collect several types of information from and about users of our Website, including:</p>

            <h3>1.1 Personal Information You Provide</h3>
            <p>When you create an account, place an order, or interact with our services, we may collect:</p>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Identity Data</strong></td>
                        <td>First name, last name, username, date of birth</td>
                    </tr>
                    <tr>
                        <td><strong>Contact Data</strong></td>
                        <td>Email address, phone number, billing/shipping address</td>
                    </tr>
                    <tr>
                        <td><strong>Financial Data</strong></td>
                        <td>Payment card details, billing information</td>
                    </tr>
                    <tr>
                        <td><strong>Transaction Data</strong></td>
                        <td>Purchase history, order details, payment records</td>
                    </tr>
                    <tr>
                        <td><strong>Profile Data</strong></td>
                        <td>Username, password, preferences, feedback, survey responses</td>
                    </tr>
                </tbody>
            </table>

            <h3>1.2 Automatically Collected Information</h3>
            <p>When you visit our Website, we automatically collect:</p>
            <ul>
                <li><strong>Technical Data:</strong> IP address, browser type, device information, operating system</li>
                <li><strong>Usage Data:</strong> Pages visited, time spent, click patterns, referring URLs</li>
                <li><strong>Location Data:</strong> General geographic location based on IP address</li>
                <li><strong>Cookie Data:</strong> Information stored through cookies and similar technologies</li>
            </ul>

            <h3>1.3 Information from Third Parties</h3>
            <p>We may receive information about you from:</p>
            <ul>
                <li>Social media platforms (if you connect your account)</li>
                <li>Payment processors (transaction verification)</li>
                <li>Delivery services (shipping updates)</li>
                <li>Analytics providers (website usage statistics)</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>We use your personal information for the following purposes:</p>

            <h3>2.1 Order Processing and Fulfillment</h3>
            <ul>
                <li>Processing and completing your orders</li>
                <li>Managing payments and billing</li>
                <li>Arranging delivery and shipping</li>
                <li>Communicating order status and updates</li>
                <li>Handling returns and refunds</li>
            </ul>

            <h3>2.2 Account Management</h3>
            <ul>
                <li>Creating and maintaining your account</li>
                <li>Authenticating your identity</li>
                <li>Managing your preferences and settings</li>
                <li>Providing customer support</li>
            </ul>

            <h3>2.3 Marketing and Communications</h3>
            <ul>
                <li>Sending promotional emails about new products and offers</li>
                <li>Personalizing your shopping experience</li>
                <li>Conducting surveys and gathering feedback</li>
                <li>Sending newsletters (with your consent)</li>
            </ul>

            <div class="info-box">
                <p><strong>You Can Opt Out:</strong> You can unsubscribe from marketing emails at any time by clicking the "unsubscribe" link in any promotional email or by adjusting your account settings.</p>
            </div>

            <h3>2.4 Website Improvement</h3>
            <ul>
                <li>Analyzing website usage and performance</li>
                <li>Improving our products and services</li>
                <li>Developing new features and functionality</li>
                <li>Conducting research and analytics</li>
            </ul>

            <h3>2.5 Security and Fraud Prevention</h3>
            <ul>
                <li>Detecting and preventing fraudulent transactions</li>
                <li>Protecting against security threats</li>
                <li>Monitoring for unauthorized access</li>
                <li>Enforcing our Terms of Service</li>
            </ul>

            <h3>2.6 Legal Compliance</h3>
            <ul>
                <li>Complying with legal obligations</li>
                <li>Responding to legal requests and proceedings</li>
                <li>Protecting our rights and property</li>
                <li>Resolving disputes</li>
            </ul>

            <h2>3. Legal Basis for Processing (for EU/EEA Users)</h2>
            <p>We process your personal data based on the following legal grounds:</p>
            <ul>
                <li><strong>Contract Performance:</strong> Processing necessary to fulfill our contract with you</li>
                <li><strong>Legitimate Interests:</strong> Processing necessary for our legitimate business interests</li>
                <li><strong>Consent:</strong> You have given explicit consent for processing</li>
                <li><strong>Legal Obligation:</strong> Processing required to comply with legal obligations</li>
            </ul>

            <h2>4. How We Share Your Information</h2>
            <p>We may share your information with the following parties:</p>

            <h3>4.1 Service Providers</h3>
            <ul>
                <li><strong>Payment Processors:</strong> To process transactions securely</li>
                <li><strong>Shipping Companies:</strong> To deliver your orders</li>
                <li><strong>Cloud Hosting:</strong> To store data securely</li>
                <li><strong>Email Services:</strong> To send communications</li>
                <li><strong>Analytics Providers:</strong> To analyze website usage</li>
            </ul>

            <h3>4.2 Business Transfers</h3>
            <p>If we are involved in a merger, acquisition, or sale of assets, your information may be transferred. We will notify you before your information becomes subject to a different privacy policy.</p>

            <h3>4.3 Legal Requirements</h3>
            <p>We may disclose your information when required by law or in response to:</p>
            <ul>
                <li>Court orders or legal processes</li>
                <li>Government or regulatory requests</li>
                <li>Protection of our rights and safety</li>
                <li>Investigation of fraud or security issues</li>
            </ul>

            <div class="warning-box">
                <p><strong>We Never Sell Your Data:</strong> We do not sell, rent, or trade your personal information to third parties for their marketing purposes.</p>
            </div>

            <h2>5. Cookies and Tracking Technologies</h2>
            <h3>5.1 What Are Cookies?</h3>
            <p>Cookies are small text files stored on your device when you visit our Website. We use cookies and similar technologies to enhance your experience.</p>

            <h3>5.2 Types of Cookies We Use</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Essential Cookies</strong></td>
                        <td>Required for the Website to function properly (shopping cart, login)</td>
                    </tr>
                    <tr>
                        <td><strong>Performance Cookies</strong></td>
                        <td>Collect information about how you use our Website</td>
                    </tr>
                    <tr>
                        <td><strong>Functionality Cookies</strong></td>
                        <td>Remember your preferences and settings</td>
                    </tr>
                    <tr>
                        <td><strong>Marketing Cookies</strong></td>
                        <td>Track your activity to deliver personalized advertisements</td>
                    </tr>
                </tbody>
            </table>

            <h3>5.3 Managing Cookies</h3>
            <p>You can control cookies through your browser settings. However, disabling certain cookies may limit your ability to use some features of our Website.</p>

            <h2>6. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal information:</p>
            <ul>
                <li><strong>Encryption:</strong> All sensitive data is encrypted using SSL/TLS technology</li>
                <li><strong>Secure Storage:</strong> Data is stored on secure servers with restricted access</li>
                <li><strong>Access Controls:</strong> Only authorized personnel can access personal data</li>
                <li><strong>Regular Audits:</strong> We conduct security audits and vulnerability assessments</li>
                <li><strong>Payment Security:</strong> We use PCI-DSS compliant payment processors</li>
            </ul>

            <div class="warning-box">
                <p><strong>No System is 100% Secure:</strong> While we strive to protect your information, no method of transmission over the internet is completely secure. We cannot guarantee absolute security.</p>
            </div>

            <h2>7. Data Retention</h2>
            <p>We retain your personal information for as long as necessary to:</p>
            <ul>
                <li>Provide our services to you</li>
                <li>Comply with legal obligations</li>
                <li>Resolve disputes and enforce our agreements</li>
                <li>Maintain business records</li>
            </ul>
            <p>Typical retention periods:</p>
            <ul>
                <li><strong>Account Data:</strong> Until you request deletion or account closure</li>
                <li><strong>Transaction Records:</strong> 7 years for tax and legal compliance</li>
                <li><strong>Marketing Data:</strong> Until you opt out or withdraw consent</li>
                <li><strong>Usage Logs:</strong> 12-24 months</li>
            </ul>

            <h2>8. Your Privacy Rights</h2>
            <p>Depending on your location, you may have the following rights:</p>

            <h3>8.1 Access and Portability</h3>
            <ul>
                <li>Request a copy of your personal data</li>
                <li>Receive your data in a structured, machine-readable format</li>
            </ul>

            <h3>8.2 Correction and Update</h3>
            <ul>
                <li>Request correction of inaccurate or incomplete data</li>
                <li>Update your account information at any time</li>
            </ul>

            <h3>8.3 Deletion (Right to be Forgotten)</h3>
            <ul>
                <li>Request deletion of your personal data</li>
                <li>Close your account permanently</li>
            </ul>

            <h3>8.4 Restriction and Objection</h3>
            <ul>
                <li>Restrict processing of your data</li>
                <li>Object to processing based on legitimate interests</li>
                <li>Opt out of marketing communications</li>
            </ul>

            <h3>8.5 Withdraw Consent</h3>
            <ul>
                <li>Withdraw consent for data processing at any time</li>
                <li>Unsubscribe from newsletters and promotional emails</li>
            </ul>

            <div class="info-box">
                <p><strong>How to Exercise Your Rights:</strong> To exercise any of these rights, please contact us at <a href="mailto:privacy@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com" style="color: var(--info); font-weight: 700;">privacy@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a> or through your account settings.</p>
            </div>

            <h2>9. Children's Privacy</h2>
            <p>Our Website is not intended for children under 18 years of age. We do not knowingly collect personal information from children. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately.</p>

            <h2>10. International Data Transfers</h2>
            <p>Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place to protect your data in accordance with this Privacy Policy and applicable laws.</p>

            <h2>11. Third-Party Links</h2>
            <p>Our Website may contain links to third-party websites. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies before providing any personal information.</p>

            <h2>12. Changes to This Privacy Policy</h2>
            <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. We will notify you of material changes by:</p>
            <ul>
                <li>Posting the updated policy on our Website</li>
                <li>Updating the "Last Updated" date</li>
                <li>Sending email notifications for significant changes</li>
                <li>Displaying a prominent notice on our Website</li>
            </ul>
            <p>Your continued use of our services after changes indicates your acceptance of the updated policy.</p>

            <h2>13. Data Protection Officer</h2>
            <p>We have appointed a Data Protection Officer to oversee compliance with this Privacy Policy. If you have questions about our privacy practices, please contact our DPO.</p>

            <h2>14. Complaints and Disputes</h2>
            <p>If you have concerns about how we handle your personal information, you have the right to:</p>
            <ul>
                <li>Contact us directly to resolve the issue</li>
                <li>File a complaint with your local data protection authority</li>
                <li>Seek legal remedies if your rights have been violated</li>
            </ul>

            <h2>15. Contact Us</h2>
            <div class="contact-box">
                <h3>Questions About Your Privacy?</h3>
                <p>If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:</p>
                <p><strong>Email:</strong> <a href="mailto:privacy@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com">privacy@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a></p>
                <p><strong>Phone:</strong> <a href="tel:+639123456789">+63 912 345 6789</a></p>
                <p><strong>Address:</strong> Quezon City, Metro Manila, Philippines</p>
                <p><strong>Data Protection Officer:</strong> <a href="mailto:dpo@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com">dpo@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a></p>
            </div>

            <div class="highlight-box" style="margin-top: 40px;">
                <p><strong>Your Trust is Our Priority:</strong> We are committed to protecting your privacy and handling your data with care and respect. Thank you for trusting <?php echo SITE_NAME; ?> with your information.</p>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>