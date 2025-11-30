<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        .maintenance-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .maintenance-container {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            max-width: 700px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .maintenance-icon {
            font-size: 100px;
            margin-bottom: 30px;
            animation: spin 3s linear infinite;
        }
        
        @keyframes spin {
            0%, 10% { transform: rotate(0deg); }
            25%, 35% { transform: rotate(-20deg); }
            50%, 60% { transform: rotate(20deg); }
            75%, 85% { transform: rotate(-10deg); }
            100% { transform: rotate(0deg); }
        }
        
        .maintenance-container h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .maintenance-container p {
            font-size: 1.2rem;
            color: #7f8c8d;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .info-box h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .info-box ul {
            list-style: none;
            padding-left: 0;
        }
        
        .info-box li {
            padding: 10px 0;
            color: #555;
            font-size: 1.05rem;
        }
        
        .info-box li:before {
            content: "✓ ";
            color: #27ae60;
            font-weight: bold;
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .contact-info {
            background: #e3f2fd;
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
            border: 2px solid #3498db;
        }
        
        .contact-info h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .contact-info p {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #555;
        }
        
        .contact-info a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .contact-info a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin: 30px 0;
        }
        
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 10px;
            animation: progress 2s ease-in-out infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        .back-soon {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 20px;
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .maintenance-container {
                padding: 40px 25px;
            }
            
            .maintenance-container h1 {
                font-size: 2rem;
            }
            
            .maintenance-icon {
                font-size: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-wrapper">
        <div class="maintenance-container">
            <div class="maintenance-icon">🔧</div>
            <h1>We'll Be Right Back!</h1>
            <p>Our website is currently undergoing scheduled maintenance to bring you an even better shopping experience.</p>
            
            <div class="progress-bar">
                <div class="progress-bar-fill"></div>
            </div>
            
            <div class="info-box">
                <h3>What's happening?</h3>
                <ul>
                    <li>System upgrades and improvements</li>
                    <li>Performance optimization</li>
                    <li>Enhanced security measures</li>
                    <li>New features being added</li>
                </ul>
            </div>
            
            <p><strong>We apologize for any inconvenience.</strong><br>Our team is working hard to get things back up and running!</p>
            
            <div class="back-soon">⏰ Back Online Soon</div>
            
            <div class="contact-info">
                <h3>Need Immediate Assistance?</h3>
                <p><strong>📧 Email:</strong> <a href="mailto:support@ncccmalls.com">support@ncccmalls.com</a></p>
                <p><strong>📞 Phone:</strong> <a href="tel:+12345678900">+1 234 567 8900</a></p>
                <p><strong>⏰ Support Hours:</strong> Mon-Fri, 9AM-6PM EST</p>
            </div>
        </div>
    </div>
</body>
</html>