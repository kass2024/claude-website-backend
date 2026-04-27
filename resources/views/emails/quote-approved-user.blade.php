<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Your quote is ready</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">Your quote is ready</h2>
    <p style="margin:0 0 12px 0;">
      Hi <strong>{{ $q->full_name }}</strong>, your quote request <strong>#{{ $q->id }}</strong> has been reviewed and approved.
    </p>

    <div style="background:#f3f4f6; padding:12px; border-radius:10px; margin:0 0 16px 0;">
      @if($q->service_category)<div><strong>Department:</strong> {{ $q->service_category }}</div>@endif
      @if($q->service_name)<div><strong>Service:</strong> {{ $q->service_name }}</div>@endif
      <div><strong>Currency:</strong> {{ $q->currency ?? 'USD' }}</div>
    </div>

    @if(is_array($q->line_items) && count($q->line_items) > 0)
      <h3 style="margin:0 0 8px 0;">Quote details</h3>
      <table style="width:100%; border-collapse:collapse; margin:0 0 12px 0;">
        <thead>
          <tr>
            <th align="left" style="border-bottom:1px solid #e5e7eb; padding:8px;">Item</th>
            <th align="right" style="border-bottom:1px solid #e5e7eb; padding:8px;">Qty</th>
            <th align="right" style="border-bottom:1px solid #e5e7eb; padding:8px;">Unit</th>
            <th align="right" style="border-bottom:1px solid #e5e7eb; padding:8px;">Amount</th>
          </tr>
        </thead>
        <tbody>
          @foreach($q->line_items as $row)
            @php
              $qty = (float) ($row['qty'] ?? 0);
              $unit = (float) ($row['unit_price'] ?? 0);
              $amount = $qty * $unit;
            @endphp
            <tr>
              <td style="border-bottom:1px solid #f3f4f6; padding:8px;">{{ $row['label'] ?? '—' }}</td>
              <td align="right" style="border-bottom:1px solid #f3f4f6; padding:8px;">{{ $qty }}</td>
              <td align="right" style="border-bottom:1px solid #f3f4f6; padding:8px;">{{ number_format($unit, 2) }}</td>
              <td align="right" style="border-bottom:1px solid #f3f4f6; padding:8px;">{{ number_format($amount, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    <div style="background:#f9fafb; padding:12px; border-radius:10px;">
      @if($q->subtotal !== null)<div><strong>Subtotal:</strong> {{ number_format((float)$q->subtotal, 2) }}</div>@endif
      @if($q->tax !== null)<div><strong>Tax:</strong> {{ number_format((float)$q->tax, 2) }}</div>@endif
      @if($q->total !== null)<div><strong>Total:</strong> {{ number_format((float)$q->total, 2) }}</div>@endif
    </div>

    @if($q->notes)
      <h3 style="margin:16px 0 8px 0;">Notes</h3>
      <div style="white-space: pre-wrap; background:#f3f4f6; padding:12px; border-radius:10px;">
        {{ $q->notes }}
      </div>
    @endif

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      If anything needs adjustment, reply to this email and our team will help.
    </p>
  </body>
</html>

