<?php


namespace Mokhosh\Reporter\Services;


use Nesk\Puphpeteer\Puppeteer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfService
{
    public function __construct(
        protected string $html,
        protected string $filename,
        protected array $options = [],
    ) {
        $this->filename = $this->filename.'.pdf';
    }

    public function createPdf(): string
    {
        $browser = (new Puppeteer)->launch();
        $page = $browser->newPage();
        $page->setContent($this->html);
        $page->pdf(array_merge($this->options, ['path' => storage_path($this->filename)]));
        $browser->close();

        return storage_path($this->filename);
    }

    public function download(): BinaryFileResponse
    {
        return response()->download($this->createPdf(), $this->filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="'.$this->filename.'"'
        ])->deleteFileAfterSend(true);
    }

    public function inline(): BinaryFileResponse
    {
        return response()->file($this->createPdf(), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="'.$this->filename.'"'
        ])->deleteFileAfterSend(true);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}