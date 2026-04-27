<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Quotation #{{ $q->id }}</title>
    <style>
      * { box-sizing: border-box; }
      body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111827; }
      .muted { color: #6b7280; }
      .h1 { font-size: 18px; font-weight: 700; margin: 0; }
      .section { margin-top: 16px; }
      .card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; }
      table { width: 100%; border-collapse: collapse; }
      th, td { padding: 8px; border-bottom: 1px solid #eef2f7; }
      th { text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
      .right { text-align: right; }
      .totalRow td { border-bottom: 0; }
      .totals { width: 45%; margin-left: auto; }
      .totals td { border-bottom: 0; padding: 4px 0; }
      .totals .label { color: #6b7280; }
      .totals .grand { font-size: 14px; font-weight: 700; padding-top: 8px; border-top: 1px solid #e5e7eb; }
      .signature { margin-top: 24px; }
      .sigLine { border-top: 1px solid #9ca3af; width: 220px; margin-top: 8px; }
      .sigImg { max-width: 220px; max-height: 80px; display: block; }
    </style>
  </head>
  <body>
    <div>
      <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
          <div class="h1">Quotation</div>
          <div class="muted">Request #{{ $q->id }}</div>
        </div>
        <div class="muted" style="text-align:right;">
          <div>Date: {{ now()->format('Y-m-d') }}</div>
          <div>Currency: {{ strtoupper($q->currency ?? 'USD') }}</div>
        </div>
      </div>
    </div>

    <div class="section card">
      <div style="display:flex; gap:16px;">
        <div style="flex:1;">
          <div class="muted" style="font-weight:700; margin-bottom:6px;">Bill to</div>
          <div><strong>{{ $q->full_name }}</strong></div>
          @if($q->company)<div>{{ $q->company }}</div>@endif
          <div>{{ $q->email }}</div>
          @if($q->phone)<div>{{ $q->phone }}</div>@endif
          @if($q->country)<div>{{ $q->country }}</div>@endif
        </div>
        <div style="flex:1;">
          <div class="muted" style="font-weight:700; margin-bottom:6px;">Service</div>
          @if($q->service_category)<div><span class="muted">Department:</span> {{ $q->service_category }}</div>@endif
          @if($q->service_name)<div><span class="muted">Service:</span> {{ $q->service_name }}</div>@endif
        </div>
      </div>
    </div>

    @php
      $items = is_array($q->line_items) ? $q->line_items : [];
    @endphp

    <div class="section card">
      <table>
        <thead>
          <tr>
            <th style="width:46%;">Item</th>
            <th class="right" style="width:12%;">Qty</th>
            <th class="right" style="width:20%;">Unit price</th>
            <th class="right" style="width:22%;">Total</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $row)
            @php
              $qty = (float) ($row['qty'] ?? 0);
              $unit = (float) ($row['unit_price'] ?? 0);
              $amount = $qty * $unit;
            @endphp
            <tr>
              <td>{{ $row['label'] ?? '—' }}</td>
              <td class="right">{{ rtrim(rtrim(number_format($qty, 2), '0'), '.') }}</td>
              <td class="right">{{ number_format($unit, 2) }}</td>
              <td class="right">{{ number_format($amount, 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="muted">No line items.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <table class="totals" style="margin-top:12px;">
        <tr>
          <td class="label">Subtotal</td>
          <td class="right">{{ number_format((float)($q->subtotal ?? 0), 2) }}</td>
        </tr>
        <tr>
          <td class="label">Tax</td>
          <td class="right">{{ number_format((float)($q->tax ?? 0), 2) }}</td>
        </tr>
        <tr>
          <td class="grand">Grand total</td>
          <td class="right grand">{{ number_format((float)($q->total ?? ((float)($q->subtotal ?? 0) + (float)($q->tax ?? 0))), 2) }}</td>
        </tr>
      </table>
    </div>

    @if($q->notes)
      <div class="section card">
        <div class="muted" style="font-weight:700; margin-bottom:6px;">Notes</div>
        <div style="white-space: pre-wrap;">{{ $q->notes }}</div>
      </div>
    @endif

    <div class="signature">
      <div class="muted" style="font-weight:700;">Authorized signature</div>
      @if(!empty($signatureDataUri))
        <img class="sigImg" src="{{ $signatureDataUri }}" alt="Signature" />
      @endif
      <div class="sigLine"></div>
    </div>
  </body>
</html>

