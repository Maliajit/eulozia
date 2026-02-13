<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000000;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #0a0a0a;
            border: 1px solid #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
        }
        .header {
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid #1a1a1a;
        }
        .body {
            padding: 40px;
            text-align: center;
        }
        .otp-container {
            margin: 30px 0;
            padding: 20px;
            background-color: #111111;
            border-radius: 12px;
            display: inline-block;
            letter-spacing: 15px;
            font-size: 36px;
            font-weight: bold;
            color: #ffffff; /* Secondary/Accent color in your theme is often White/Gray-300 */
            border: 1px solid #333333;
        }
        .footer {
            padding: 30px;
            text-align: center;
            background-color: #050505;
            color: #666666;
            font-size: 12px;
        }
        h1 { margin: 0; font-size: 24px; color: #ffffff; }
        p { color: #aaaaaa; line-height: 1.6; }
        .accent { color: #cccccc; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EULOZIA</h1>
        </div>
        <div class="body">
            <h2>Verify Your Account</h2>
            <p>Thank you for joining <span class="accent">Eulozia</span>. To complete your registration, please use the 6-digit verification code below:</p>
            
            <div class="otp-container">
                {{ $otp }}
            </div>
            
            <p>This code will expire in 5 minutes. If you did not request this code, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; 2026 Eulozia. All rights reserved.<br>
            Secure E-commerce Solutions.
        </div>
    </div>
</body>
</html>
