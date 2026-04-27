<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>New quote request</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">New quote request (#{{ $q->id }})</h2>

    <p style="margin:0 0 12px 0;">
      From: <strong>{{ $q->full_name }}</strong>
      @if($q->company) ({{ $q->company }}) @endif
    </p>

    <ul style="margin:0 0 16px 18px; padding:0;">
      <li><strong>Email:</strong> {{ $q->email }}</li>
      @if($q->phone)<li><strong>Phone:</strong> {{ $q->phone }}</li>@endif
      @if($q->country)<li><strong>Country:</strong> {{ $q->country }}</li>@endif
      @if($q->service_category)<li><strong>Department:</strong> {{ $q->service_category }}</li>@endif
      @if($q->service_name)<li><strong>Service:</strong> {{ $q->service_name }}</li>@endif
      <li><strong>Status:</strong> {{ $q->status }}</li>
    </ul>

    <h3 style="margin:0 0 8px 0;">Project summary</h3>
    <div style="white-space: pre-wrap; background:#f3f4f6; padding:12px; border-radius:10px;">
      {{ $q->project_summary }}
    </div>

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      Open the admin dashboard to build the quote and approve it for the customer.
    </p>
  </body>
</html>

