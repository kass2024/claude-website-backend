<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Message received</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">We received your message</h2>

    <p style="margin:0 0 12px 0;">
      Hi <strong>{{ $m->full_name }}</strong>, thank you for contacting us. Your message has been received and we’ll get back to you soon.
    </p>

    <div style="background:#f3f4f6; padding:12px; border-radius:10px;">
      <div><strong>Reference:</strong> #{{ $m->id }}</div>
      @if($m->service_interest)<div><strong>Service interest:</strong> {{ $m->service_interest }}</div>@endif
    </div>

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      If you did not submit this message, you can ignore this email.
    </p>
  </body>
</html>

