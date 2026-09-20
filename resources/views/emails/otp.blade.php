```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f4f4;padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:linear-gradient(135deg,#4f46e5,#7c3aed);padding:35px 20px;">

                            <h1 style="margin:0;color:#ffffff;font-size:28px;">
                                Multivendor E-Commerce
                            </h1>

                            <p style="margin:10px 0 0;color:#e0e7ff;font-size:15px;">
                                Secure Email Verification
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 35px;">

                            <h2 style="margin:0 0 15px;color:#111827;font-size:24px;">
                                Hello, {{ $customerName }}
                            </h2>

                            <p style="margin:0 0 20px;color:#4b5563;font-size:16px;line-height:28px;">
                                Thank you for registering with us.
                                Please use the OTP below to verify your email address.
                            </p>

                            <!-- OTP Box -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">

                                        <div style="
                                            display:inline-block;
                                            background:#f3f4f6;
                                            border:2px dashed #4f46e5;
                                            padding:18px 40px;
                                            border-radius:12px;
                                            margin:20px 0;
                                        ">
                                            <span style="
                                                font-size:36px;
                                                letter-spacing:8px;
                                                font-weight:bold;
                                                color:#4f46e5;
                                            ">
                                                {{ $otp }}
                                            </span>
                                        </div>

                                    </td>
                                </tr>
                            </table>

                            <p style="margin:20px 0 0;color:#6b7280;font-size:15px;line-height:26px;">
                                This OTP is valid for
                                <strong>10 minutes</strong>.
                                Do not share this code with anyone.
                            </p>

                            <p style="margin:25px 0 0;color:#6b7280;font-size:15px;line-height:26px;">
                                If you did not create this account, you can safely ignore this email.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#f9fafb;padding:25px;border-top:1px solid #e5e7eb;">

                            <p style="margin:0;color:#9ca3af;font-size:14px;">
                                © {{ date('Y') }} Multivendor E-Commerce. All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
```
