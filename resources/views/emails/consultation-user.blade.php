<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Consultation request received</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">We received your consultation request</h2>

    <p style="margin:0 0 12px 0;">
      Hi <strong>{{ $c->full_name }}</strong>, thank you for reaching out. Your request has been received and our team will review it.
    </p>

    <div style="background:#f3f4f6; padding:12px; border-radius:10px;">
      <div><strong>Reference:</strong> #{{ $c->id }}</div>
      @if($c->consultation_type)<div><strong>Consultation type:</strong> {{ $c->consultation_type }}</div>@endif
      @if($c->preferred_date)<div><strong>Preferred date:</strong> {{ $c->preferred_date->toDateString() }}</div>@endif
    </div>

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      If you did not submit this request, you can ignore this email.
    </p>
  </body>
</html>

