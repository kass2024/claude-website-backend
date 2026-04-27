<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>New contact message</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">New contact message (#{{ $m->id }})</h2>

    <p style="margin:0 0 12px 0;">
      From: <strong>{{ $m->full_name }}</strong>
      @if($m->company) ({{ $m->company }}) @endif
    </p>

    <ul style="margin:0 0 16px 18px; padding:0;">
      <li><strong>Email:</strong> {{ $m->email }}</li>
      @if($m->phone)<li><strong>Phone:</strong> {{ $m->phone }}</li>@endif
      @if($m->country)<li><strong>Country:</strong> {{ $m->country }}</li>@endif
      @if($m->service_interest)<li><strong>Service interest:</strong> {{ $m->service_interest }}</li>@endif
    </ul>

    <h3 style="margin:0 0 8px 0;">Message</h3>
    <div style="white-space: pre-wrap; background:#f3f4f6; padding:12px; border-radius:10px;">
      {{ $m->message }}
    </div>

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      Replying to this email will send a response to {{ $m->email }}.
    </p>
  </body>
</html>

