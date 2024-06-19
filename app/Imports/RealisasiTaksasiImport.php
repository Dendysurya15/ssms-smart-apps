<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\DataServiceImportRealisasi;

class RealisasiTaksasiImport implements WithHeadingRow, WithMultipleSheets
{
    /**
     * @param Collection $collection
     */

    public function headingRow(): int
    {
        return 2;
    }

    protected $dataService;
    protected $month;

    public function __construct(DataServiceImportRealisasi $dataService, $month)
    {
        $this->dataService = $dataService;
        $this->month = $month;
    }


    public function sheets(): array
    {
        return [
            'TK AFD' => new TenagaKerjaSheetImport($this->dataService, $this->month),
            'TAKSASI VS REALISASI GM' => new RealisasiImport($this->dataService, $this->month),
        ];
    }
}
