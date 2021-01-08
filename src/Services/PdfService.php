<?php


namespace Mokhosh\Reporter\Services;


use Nesk\Puphpeteer\Puppeteer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfService
{
    public function __construct(public string $html) {}

    public function createPdf($filename = 'tmp-report.pdf'): string
    {
        $browser = (new Puppeteer)->launch();
        $page = $browser->newPage();
        $page->setContent($this->html);
        $page->pdf(["path" => storage_path($filename)]);
        $browser->close();

        return storage_path($filename);
    }

    public function download($filename = 'tmp-report.pdf'): BinaryFileResponse
    {
        return response()->download($this->createPdf($filename), $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="'.$filename.'"'
        ])->deleteFileAfterSend(true);
    }

    public function inline($filename = 'tmp-report.pdf'): BinaryFileResponse
    {
        return response()->file($this->createPdf($filename), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="'.$filename.'"'
        ])->deleteFileAfterSend(true);
    }
}