<?php

namespace App\Services\Pdf;

use App\Models\Order;

interface PdfServiceInterface
{
    public function generatePdf(string $htmlContent): mixed;

    public function concatenatePdfs(array $pdfPaths, string $outputPath): void;
}
