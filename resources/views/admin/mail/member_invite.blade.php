<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Welcome to {{ $app_name }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* Basic reset for email clients */
    body,table,td,a{ -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table,td{ mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img{ -ms-interpolation-mode:bicubic; }
    img { border:0; height:auto; line-height:100%; outline:none; text-decoration:none; }
    body { margin:0; padding:0; width:100% !important; font-family: Arial, Helvetica, sans-serif; background:#f4f6f8; color:#333333; }

    /* Container */
    .email-wrap { width:100%; max-width:680px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05); }

    /* Header */
    .email-header { padding:20px 24px; background: #0b78d1; color: #ffffff; text-align:left; }
    .logo { font-weight:700; font-size:18px; letter-spacing:0.2px; }

    /* Body */
    .email-body { padding:24px; }
    .greeting { font-size:18px; margin:0 0 8px 0; }
    .lead { font-size:14px; margin:0 0 16px 0; color:#555555; }

    /* Credentials box */
    .creds { background:#f7f9fb; border:1px solid #e6eef7; padding:14px; border-radius:6px; margin:12px 0 18px 0; }
    .creds table { width:100%; font-size:14px; color:#333; border-collapse:collapse; }
    .creds td { padding:6px 0; vertical-align:top; }
    .label { color:#666; width:120px; font-weight:600; }

    /* CTA */
    .btn { display:inline-block; background:#0b78d1; color:#fff; padding:12px 18px; text-decoration:none; border-radius:6px; font-weight:600; margin-top:8px; }
    .small { font-size:12px; color:#888; margin-top:12px; }

    /* Footer */
    .email-footer { padding:18px 24px; font-size:12px; color:#888; text-align:center; background:#fafbfc; }

    /* Mobile */
    @media only screen and (max-width:480px) {
      .email-wrap { margin:10px; }
      .label { width:110px; display:block; }
    }
  </style>
</head>
<body>
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8; padding:24px 0;">
    <tr>
      <td align="center">
        <table role="presentation" class="email-wrap" cellpadding="0" cellspacing="0">
          <!-- Header -->
          <tr>
            <td class="email-header">
              <div class="logo">{{ $app_name }}</div>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td class="email-body">
              <p class="greeting">Hello {{ $name }},</p>
              <p class="lead">
                You've been invited to join <strong>{{ $app_name }}</strong> as a <strong>{{ strtoupper($role) }}</strong>.
                Below are your account details — keep them safe.
              </p>

              <div class="creds" role="article" aria-label="Account credentials">
                <table role="presentation">
                  <tr>
                    <td class="label">Name</td>
                    <td>{{ $name }}</td>
                  </tr>
                  <tr>
                    <td class="label">Email</td>
                    <td>{{ $email }}</td>
                  </tr>
                  <tr>
                    <td class="label">Password</td>
                    <td><code style="background:transparent; padding:2px 6px; border-radius:4px; border:1px solid #e0e6ef;">{{ $password }}</code></td>
                  </tr>
                </table>
              </div>

              <p style="margin:0;">
                To sign in and start using the short URL generator, click the button below:
              </p>

              <p style="margin:14px 0;">
                <a href="{{ $login_url }}" class="btn" target="_blank" rel="noopener">Sign in to {{ $app_name }}</a>
              </p>

              {{-- <p class="small">
                Tip: For security, you should change this temporary password after first login. If you did not expect this email, please ignore it or contact the admin.
              </p> --}}
            </td>
          </tr>

          <!-- Footer -->
          {{-- <tr>
            <td class="email-footer">
              © {{ date('Y') }} {{ $app_name }} • <span style="color:#666;">Need help? Reply to this email.</span>
            </td>
          </tr> --}}
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
