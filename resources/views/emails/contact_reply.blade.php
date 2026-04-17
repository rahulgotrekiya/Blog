<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re: {{ $contactMessage->subject }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f7;
            color: #333333;
            padding: 40px 20px;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
        }
        .header .logo {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #111111;
            text-decoration: none;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .card-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 32px 36px;
            color: #ffffff;
        }
        .card-header .label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 8px;
        }
        .card-header h1 {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
            color: #ffffff;
        }
        .card-body {
            padding: 36px;
        }
        .greeting {
            font-size: 16px;
            color: #555;
            margin-bottom: 28px;
            line-height: 1.6;
        }
        .greeting strong { color: #111; }

        /* Reply block */
        .reply-block {
            background: #f9f9fb;
            border: 1px solid #e8e8ee;
            border-left: 4px solid #0f3460;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .reply-block .block-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #0f3460;
            margin-bottom: 12px;
        }
        .reply-block p {
            font-size: 15px;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
        }

        /* Original message block */
        .original-block {
            background: #f4f4f7;
            border: 1px solid #e0e0e8;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 32px;
        }
        .original-block .block-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #888;
            margin-bottom: 12px;
        }
        .original-block p {
            font-size: 14px;
            line-height: 1.8;
            color: #666;
            white-space: pre-wrap;
        }

        .divider {
            border: none;
            border-top: 1px solid #ebebec;
            margin: 28px 0;
        }

        .meta-row {
            display: flex;
            gap: 32px;
            margin-bottom: 12px;
        }
        .meta-item .meta-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #999;
            margin-bottom: 2px;
        }
        .meta-item .meta-value {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 32px 36px;
            border-top: 1px solid #f0f0f0;
        }
        .footer p {
            font-size: 12px;
            color: #aaa;
            line-height: 1.7;
        }
        .footer .blog-name {
            font-weight: 700;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header -->
        <div class="header">
            <span class="logo">{{ config('app.name') }}</span>
        </div>

        <!-- Card -->
        <div class="card">

            <!-- Card Header -->
            <div class="card-header">
                <div class="label">Support Reply</div>
                <h1>Re: {{ $contactMessage->subject }}</h1>
            </div>

            <!-- Card Body -->
            <div class="card-body">

                <p class="greeting">
                    Hi <strong>{{ $contactMessage->name }}</strong>,<br>
                    Thank you for reaching out. Our team has reviewed your message and sent you the following reply:
                </p>

                <!-- Admin Reply -->
                <div class="reply-block">
                    <div class="block-label">Reply from {{ config('app.name') }}</div>
                    <p>{{ $contactMessage->replied_message }}</p>
                </div>

                <!-- Original Message -->
                <div class="original-block">
                    <div class="block-label">Your Original Message</div>
                    <p>{{ $contactMessage->message }}</p>
                </div>

                <!-- Meta -->
                <div class="meta-row">
                    <div class="meta-item">
                        <div class="meta-label">Subject</div>
                        <div class="meta-value">{{ $contactMessage->subject }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Sent on</div>
                        <div class="meta-value">{{ $contactMessage->created_at->format('M d, Y') }}</div>
                    </div>
                </div>

            </div>

            <!-- Footer inside card -->
            <div class="footer">
                <p>
                    This email was sent by <span class="blog-name">{{ config('app.name') }}</span> in response to your contact form submission.<br>
                    Please do not reply directly to this email. If you have further questions, visit our
                    <a href="{{ config('app.url') }}/contact" style="color: #0f3460; text-decoration: none;">contact page</a>.
                </p>
            </div>

        </div>

    </div>
</body>
</html>
