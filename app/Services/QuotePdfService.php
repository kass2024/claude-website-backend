<?php

namespace App\Services;

use App\Models\QuoteRequest;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;

class QuotePdfService
{
    /**
     * Render a PDF binary string for the given quote.
     */
    public function render(QuoteRequest $quote): string
    {
        $signatureDataUri = $this->signatureDataUri();

        $html = view('pdf.quote', [
            'q' => $quote,
            'signatureDataUri' => $signatureDataUri,
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    private function signatureDataUri(): ?string
    {
        $path = (string) env('QUOTE_SIGNATURE_PATH', 'assets/signature.png');
        $path = ltrim($path, '/');

        // Allow specifying either a public-relative path (`assets/signature.png`) or an absolute path.
        $full = Str::startsWith($path, ['\\', '/', 'C:', 'D:', 'E:']) ? $path : public_path($path);
        if (!is_file($full)) {
            return null;
        }

        $bin = @file_get_contents($full);
        if ($bin === false || $bin === '') {
            return null;
        }

        $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            default => 'image/png',
        };

        return 'data:' . $mime . ';base64,' . base64_encode($bin);
    }
}

