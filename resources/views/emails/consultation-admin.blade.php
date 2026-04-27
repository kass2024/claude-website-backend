<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>New consultation request</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">New consultation request (#{{ $c->id }})</h2>

    <p style="margin:0 0 12px 0;">
      From: <strong>{{ $c->full_name }}</strong>
      @if($c->company) ({{ $c->company }}) @endif
    </p>

    <ul style="margin:0 0 16px 18px; padding:0;">
      <li><strong>Email:</strong> {{ $c->email }}</li>
      @if($c->phone)<li><strong>Phone:</strong> {{ $c->phone }}</li>@endif
      @if($c->country)<li><strong>Country:</strong> {{ $c->country }}</li>@endif
      @if($c->service_category)<li><strong>Service category:</strong> {{ $c->service_category }}</li>@endif
      @if($c->consultation_type)<li><strong>Consultation type:</strong> {{ $c->consultation_type }}</li>@endif
      @if($c->preferred_date)<li><strong>Preferred date:</strong> {{ $c->preferred_date->toDateString() }}</li>@endif
    </ul>

    <h3 style="margin:0 0 8px 0;">Project summary</h3>
    <div style="white-space: pre-wrap; background:#f3f4f6; padding:12px; border-radius:10px;">
      {{ $c->project_summary }}
    </div>

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      Replying to this email will send a response to {{ $c->email }}.
    </p>
  </body>
</html>

