<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your CGCANO Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .content {
            background-color: white;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .credentials {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Welcome to CGCANO!</h1>
        <p>Your account has been created successfully</p>
    </div>

    <div class="content">
        <h2>Hello {{ $user->fullname }},</h2>

        <p>Thank you for purchasing tickets with us! We've automatically created an account for you to manage your
            bookings and access your tickets.</p>

        <div class="credentials">
            <h3>Your Login Credentials:</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Temporary Password:</strong> {{ $tempPassword }}</p>
        </div>

        <div class="warning">
            <strong>Important Security Notice:</strong><br>
            This is a temporary password. For security reasons, please log in and change your password immediately using
            the "Forgot Password" option.
        </div>

        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
            <a href="{{ $forgotPasswordUrl }}" class="button" style="background-color: #28a745;">Change Password</a>
        </div>

        <h3>What you can do with your account:</h3>
        <ul>
            <li>View and download your tickets</li>
            <li>Track your booking history</li>
            <li>Receive updates about your events</li>
            <li>Manage your profile information</li>
            <li>Purchase future tickets easily</li>
        </ul>

        <p><strong>Next Steps:</strong></p>
        <ol>
            <li>Click the "Login to Your Account" button above</li>
            <li>Use your email and the temporary password provided</li>
            <li>Immediately change your password for security</li>
            <li>Complete your profile if needed</li>
        </ol>
    </div>

    <div class="footer">
        <p>If you have any questions or need assistance, please contact our support team.</p>
        <p>This email was sent because you purchased tickets as a guest on our platform.</p>
        <p>&copy; {{ date('Y') }} CGCANO. All rights reserved.</p>
    </div>
</body>

</html>