<?php

namespace Mokhosh\Reporter\Services;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Mokhosh\Reporter\Events\ExportSaved;
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

    public function queueExport()
    {
        dispatch(function () {
            Excel::queue($this->createExcel(), 'temp-exports/'.$this->filename);
            (new ExportSaved('temp-exports/'.$this->filename))->dispatch();
        });
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}

class ExportView implements FromView, ShouldAutoSize
{
    use Exportable;
    public function __construct(private View $view) {}
    public function view(): View {return $this->view;}
}
