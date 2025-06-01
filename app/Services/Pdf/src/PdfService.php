<?php

namespace App\Services\Pdf\src;

use App\Services\Pdf\PdfServiceInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use setasign\Fpdi\Fpdi;

class PdfService implements PdfServiceInterface
{
    public function generatePdf(string $htmlContent): mixed
    {
        $pdfServiceUrl = config('services.pdf.url');

        try {
            $response = Http::post($pdfServiceUrl, [
                'htmlContent' => $htmlContent
            ]);

            if ($response->successful()) {
                return $response->body();
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function concatenatePdfs(array $pdfPaths, string $outputPath): void
    {
        $pdf = new Fpdi();

        foreach ($pdfPaths as $pdfPath) {
            $pageCount = $pdf->setSourceFile($pdfPath);

            for ($page = 1; $page <= $pageCount; $page++) {
                $templateId = $pdf->importPage($page);
                $pdf->AddPage();
                $pdf->useTemplate($templateId);
            }
        }

        // Save the combined PDF
        $pdf->Output($outputPath, 'F');
    }
}
