<?php

namespace Mokhosh\Reporter\Services;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelService
{
    public function __construct(
        protected View $view,
        protected string $filename,
        protected array $options = [],
    ) {
        $this->filename = $this->filename.'.xlsx';
    }

    public function createExcel(): ExportView
    {
        return new ExportView($this->view);
    }

    public function download(): BinaryFileResponse
    {
        return Excel::download($this->createExcel(), $this->filename);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}

class ExportView implements FromView
{
    use Exportable;
    public function __construct(private View $view) {}
    public function view(): View {return $this->view;}
}