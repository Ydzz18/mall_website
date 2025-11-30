<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns & Refunds - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .returns-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .returns-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .returns-header h1 {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .returns-header p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-box {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 60px;
            box-shadow: 0 20px 60px rgba(124, 58, 237, 0.3);
        }

        .hero-box h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .hero-box p {
            font-size: 1.2rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .process-step {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: var(--transition);
            position: relative;
        }

        .process-step:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(124, 58, 237, 0.2);
        }

        .step-number {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 900;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
        }

        .step-icon {
            font-size: 3rem;
            margin: 30px 0 20px;
        }

        .process-step h3 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .process-step p {
            color: var(--text-light);
            line-height: 1.7;
        }

        .info-section {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .info-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary);
        }

        .info-section h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin: 30px 0 15px;
        }

        .info-section p {
            color: var(--text);
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .info-section ul {
            margin: 20px 0;
            padding-left: 30px;
        }

        .info-section li {
            margin-bottom: 12px;
            color: var(--text);
            line-height: 1.8;
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

        .success-box {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--success);
            margin: 25px 0;
        }

        .error-box {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--error);
            margin: 25px 0;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .comparison-table thead {
            background: var(--gradient-primary);
            color: white;
        }

        .comparison-table th {
            padding: 18px;
            text-align: left;
            font-weight: 700;
            font-size: 1rem;
        }

        .comparison-table td {
            padding: 18px;
            border-bottom: 1px solid var(--border);
        }

        .comparison-table tbody tr:last-child td {
            border-bottom: none;
        }

        .comparison-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%);
        }

        .checklist {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            padding: 30px;
            border-radius: 16px;
            margin: 30px 0;
        }

        .checklist h4 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 20px;
        }

        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(124, 58, 237, 0.1);
        }

        .checklist-item:last-child {
            border-bottom: none;
        }

        .check-icon {
            color: var(--success);
            font-size: 1.5rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .check-text {
            color: var(--text);
            line-height: 1.7;
        }

        .timeline-refund {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 40px 0;
            position: relative;
            padding: 30px 0;
        }

        .timeline-refund::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            z-index: 0;
        }

        .timeline-point {
            text-align: center;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .timeline-dot {
            width: 50px;
            height: 50px;
            background: white;
            border: 4px solid var(--primary);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .timeline-label {
            font-weight: 700;
            color: var(--dark);
            font-size: 0.95rem;
            background: white;
            padding: 5px 10px;
            border-radius: 8px;
        }

        @media (max-width: 968px) {
            .timeline-refund {
                flex-direction: column;
                gap: 30px;
            }

            .timeline-refund::before {
                width: 4px;
                height: 100%;
                left: 25px;
                top: 0;
            }

            .timeline-point {
                display: flex;
                align-items: center;
                gap: 20px;
                text-align: left;
            }

            .timeline-dot {
                margin: 0;
            }
        }

        @media (max-width: 768px) {
            .returns-header h1 {
                font-size: 2.2rem;
            }

            .info-section {
                padding: 30px 25px;
            }

            .hero-box {
                padding: 40px 25px;
            }

            .process-steps {
                grid-template-columns: 1fr;
            }

            .comparison-table {
                font-size: 0.9rem;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .returns-header h1 {
                font-size: 1.8rem;
            }

            .info-section {
                padding: 25px 20px;
            }

            .comparison-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="returns-container">
        <div class="returns-header">
            <h1>Returns & Refunds Policy</h1>
            <p>We want you to be completely satisfied with your purchase. If you're not happy, we'll make it right.</p>
        </div>

        <div class="hero-box">
            <h2>30-Day Hassle-Free Returns</h2>
            <p>Changed your mind? No problem! Return most items within 30 days for a full refund or exchange.</p>
        </div>

        <div class="info-section">
            <h2>📋 Return Eligibility</h2>
            
            <h3>Items Eligible for Return</h3>
            <p>To be eligible for a return, your item must meet the following conditions:</p>
            
            <div class="checklist">
                <h4>✓ Return Checklist</h4>
                <div class="checklist-item">
                    <span class="check-icon">✓</span>
                    <span class="check-text"><strong>Within 30 days:</strong> Return request initiated within 30 days of delivery</span>
                </div>
                <div class="checklist-item">
                    <span class="check-icon">✓</span>
                    <span class="check-text"><strong>Unused condition:</strong> Item must be unused, unworn, and unwashed</span>
                </div>
                <div class="checklist-item">
                    <span class="check-icon">✓</span>
                    <span class="check-text"><strong>Original packaging:</strong> Must be in original packaging with all tags attached</span>
                </div>
                <div class="checklist-item">
                    <span class="check-icon">✓</span>
                    <span class="check-text"><strong>Proof of purchase:</strong> Receipt or order confirmation required</span>
                </div>
                <div class="checklist-item">
                    <span class="check-icon">✓</span>
                    <span class="check-text"><strong>Complete accessories:</strong> All accessories, manuals, and parts included</span>
                </div>
            </div>

            <h3>Non-Returnable Items</h3>
            <div class="error-box">
                <p><strong>⚠️ The following items cannot be returned:</strong></p>
            </div>
            <ul>
                <li><strong>Personalized or custom-made products</strong> - Items made specifically for you</li>
                <li><strong>Perishable goods</strong> - Food items, fresh flowers, plants</li>
                <li><strong>Intimate items</strong> - Underwear, swimwear, body jewelry</li>
                <li><strong>Sanitary products</strong> - Personal care items, hygiene products</li>
                <li><strong>Digital products</strong> - Downloaded software, e-books, digital content</li>
                <li><strong>Items marked "Final Sale"</strong> - Clearance items with no return option</li>
                <li><strong>Gift cards</strong> - Cannot be returned or exchanged for cash</li>
            </ul>

            <div class="warning-box">
                <p><strong>📦 Special Handling Items:</strong> Electronics, appliances, and fragile items must be returned in their original packaging. Keep boxes and packaging materials until you're certain you'll keep the item.</p>
            </div>
        </div>

        <div class="info-section">
            <h2>🔄 How to Return an Item</h2>
            
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-icon">📱</div>
                    <h3>Initiate Return</h3>
                    <p>Log into your account, go to "My Orders," and select the item you want to return. Click "Return Item" and choose your reason.</p>
                </div>

                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-icon">📋</div>
                    <h3>Get Return Label</h3>
                    <p>You'll receive a prepaid return shipping label via email. Print it and attach it securely to your package.</p>
                </div>

                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-icon">📦</div>
                    <h3>Pack & Ship</h3>
                    <p>Pack the item securely in its original packaging. Drop off at any courier location or schedule a pickup.</p>
                </div>

                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-icon">💰</div>
                    <h3>Get Refund</h3>
                    <p>Once we receive and inspect your return, we'll process your refund within 7-10 business days.</p>
                </div>
            </div>

            <div class="info-box">
                <p><strong>💡 Pro Tip:</strong> Take photos of the item before packing it for return. This helps resolve any disputes about the item's condition.</p>
            </div>

            <h3>Alternative Return Methods</h3>
            <p>Can't print a return label? No problem! You can also return items by:</p>
            <ul>
                <li><strong>Email us:</strong> Contact <a href="mailto:returns@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com" style="color: var(--primary); font-weight: 700;">returns@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a> with your order number</li>
                <li><strong>Call us:</strong> Phone +63 912 345 6789 and speak with our returns team</li>
                <li><strong>Live chat:</strong> Use our 24/7 chat support for instant assistance</li>
            </ul>
        </div>

        <div class="info-section">
            <h2>💳 Refund Processing</h2>
            
            <h3>Refund Timeline</h3>
            <p>Here's what to expect when returning an item:</p>

            <div class="timeline-refund">
                <div class="timeline-point">
                    <div class="timeline-dot">📦</div>
                    <div class="timeline-label">Item Received</div>
                </div>
                <div class="timeline-point">
                    <div class="timeline-dot">🔍</div>
                    <div class="timeline-label">Inspection<br>(1-2 days)</div>
                </div>
                <div class="timeline-point">
                    <div class="timeline-dot">✓</div>
                    <div class="timeline-label">Approved<br>(Same day)</div>
                </div>
                <div class="timeline-point">
                    <div class="timeline-dot">💰</div>
                    <div class="timeline-label">Refund Issued<br>(7-10 days)</div>
                </div>
            </div>

            <h3>Refund Methods</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Payment Method</th>
                        <th>Refund Process</th>
                        <th>Timeline</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Credit/Debit Card</strong></td>
                        <td>Refund to original card</td>
                        <td>7-10 business days</td>
                    </tr>
                    <tr>
                        <td><strong>PayPal</strong></td>
                        <td>Refund to PayPal account</td>
                        <td>5-7 business days</td>
                    </tr>
                    <tr>
                        <td><strong>GCash</strong></td>
                        <td>Refund to GCash wallet</td>
                        <td>3-5 business days</td>
                    </tr>
                    <tr>
                        <td><strong>Cash on Delivery</strong></td>
                        <td>Bank transfer or store credit</td>
                        <td>10-14 business days</td>
                    </tr>
                </tbody>
            </table>

            <h3>What Gets Refunded</h3>
            <ul>
                <li><strong>Item price:</strong> Full product cost refunded</li>
                <li><strong>Original shipping:</strong> Refunded for defective/incorrect items only</li>
                <li><strong>Taxes:</strong> All applicable taxes refunded</li>
                <li><strong>Gift wrapping:</strong> Refunded if item unopened</li>
            </ul>

            <div class="warning-box">
                <p><strong>⚠️ Non-Refundable Fees:</strong> Return shipping costs are not refunded unless the return is due to our error (defective item, wrong item sent, etc.).</p>
            </div>

            <h3>Partial Refunds</h3>
            <p>In some cases, only partial refunds may be granted:</p>
            <ul>
                <li>Items with obvious signs of use or damage not caused during shipping</li>
                <li>Items returned more than 30 days after delivery</li>
                <li>Items not in original packaging or missing components</li>
                <li>Items opened or used (subject to 20% restocking fee)</li>
            </ul>
        </div>

        <div class="info-section">
            <h2>🔄 Exchanges</h2>
            
            <h3>How Exchanges Work</h3>
            <p>Want a different size or color? We'll exchange it for you:</p>
            <ul>
                <li>Exchanges are processed faster than returns (5-7 days)</li>
                <li>We'll ship your replacement as soon as we receive the original item</li>
                <li>No additional shipping charges for exchanges due to our error</li>
                <li>If exchanging for a higher-priced item, pay the difference</li>
                <li>If exchanging for a lower-priced item, receive the difference as store credit</li>
            </ul>

            <div class="success-box">
                <p><strong>✓ Fast Exchange Program:</strong> For size/color exchanges on in-stock items, we can ship your replacement immediately! Contact customer service to arrange a fast exchange.</p>
            </div>

            <h3>When to Choose Exchange vs Return</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Situation</th>
                        <th>Best Option</th>
                        <th>Why</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Wrong size/color</td>
                        <td>Exchange</td>
                        <td>Faster process, no refund wait</td>
                    </tr>
                    <tr>
                        <td>Changed your mind</td>
                        <td>Return</td>
                        <td>Get your money back</td>
                    </tr>
                    <tr>
                        <td>Defective item</td>
                        <td>Exchange</td>
                        <td>Immediate replacement</td>
                    </tr>
                    <tr>
                        <td>Want different product</td>
                        <td>Return</td>
                        <td>Full refund, buy what you want</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="info-section">
            <h2>🛡️ Defective or Damaged Items</h2>
            
            <h3>If You Receive a Defective or Damaged Item</h3>
            <p>We sincerely apologize! Here's what to do:</p>
            
            <ol style="padding-left: 25px; margin: 20px 0;">
                <li style="margin-bottom: 15px;"><strong>Take photos immediately</strong> - Document the damage or defect</li>
                <li style="margin-bottom: 15px;"><strong>Contact us within 48 hours</strong> - Email photos to <a href="mailto:support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com" style="color: var(--primary); font-weight: 700;">support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a></li>
                <li style="margin-bottom: 15px;"><strong>Keep all packaging</strong> - We may need it for shipping claims</li>
                <li style="margin-bottom: 15px;"><strong>Choose your solution</strong> - Replacement, repair, or full refund</li>
            </ol>

            <div class="success-box">
                <p><strong>✓ Priority Processing:</strong> Defective and damaged item returns are processed immediately with free return shipping. We'll send your replacement via express shipping at no extra cost.</p>
            </div>

            <h3>What We Cover</h3>
            <ul>
                <li>Manufacturing defects within warranty period</li>
                <li>Items damaged during shipping</li>
                <li>Wrong items sent to you</li>
                <li>Missing parts or accessories</li>
                <li>Items that don't match description</li>
            </ul>
        </div>

        <div class="info-section">
            <h2>📞 Need Help with Your Return?</h2>
            <p>Our customer service team is here to make your return process as smooth as possible:</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
                <div style="text-align: center; padding: 25px; background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%); border-radius: 12px;">
                    <div style="font-size: 2.5rem; margin-bottom: 15px;">📧</div>
                    <h4 style="color: var(--dark); margin-bottom: 10px;">Email Support</h4>
                    <a href="mailto:returns@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com" style="color: var(--primary); font-weight: 700; text-decoration: none;">returns@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</a>
                </div>
                <div style="text-align: center; padding: 25px; background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%); border-radius: 12px;">
                    <div style="font-size: 2.5rem; margin-bottom: 15px;">📞</div>
                    <h4 style="color: var(--dark); margin-bottom: 10px;">Phone Support</h4>
                    <a href="tel:+639123456789" style="color: var(--primary); font-weight: 700; text-decoration: none;">+63 912 345 6789</a>
                </div>
                <div style="text-align: center; padding: 25px; background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%); border-radius: 12px;">
                    <div style="font-size: 2.5rem; margin-bottom: 15px;">💬</div>
                    <h4 style="color: var(--dark); margin-bottom: 10px;">Live Chat</h4>
                    <a href="#" style="color: var(--primary); font-weight: 700; text-decoration: none;">Chat Now (24/7)</a>
                </div>
            </div>
        </div>

        <div class="info-section" style="text-align: center; background: var(--gradient-primary); color: white;">
            <h2 style="color: white; border-bottom: 3px solid white;">Your Satisfaction is Our Priority</h2>
            <p style="font-size: 1.2rem; margin-bottom: 20px;">We're committed to making returns and refunds as easy and stress-free as possible. If you have any questions or concerns, don't hesitate to reach out!</p>
            <a href="contact.php" class="btn" style="background: white; color: var(--primary); display: inline-block; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 700; margin-top: 10px;">Contact Customer Service</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>