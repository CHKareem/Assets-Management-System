<?php

namespace App\Exports;

use App\Models\Maintenance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\withStrictNullComparison;
use Maatwebsite\Excel\Concerns\shouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withMapping;

class CustomMaintenanceExport extends DefaultValueBinder implements FromQuery,WithHeadings, withStrictNullComparison, shouldAutoSize, WithStyles, WithEvents, WithCustomValueBinder, withMapping
{

    use Exportable;

    public function __construct($maintenanceCode){
        $this->maintenanceCode = $maintenanceCode;
        // $this->codeNamaa = $codeNamaa;
        // $this->serialNumber = $serialNumber;
        // $this->employeeName = $employeeName;
    }

    public function query()
    {
            return Maintenance::with('assets', 'assets.items', 'assets.types')
            ->where('asset_id', $this->maintenanceCode);
            // ->orWhere('employee_id', $this->maintenanceCode)
    }

    public function headings(): array
    {
        return [
            ' Item Name ',
            ' Type Name ',
            ' Code Namaa ',
            ' Send Date ',
            ' Receive Date ',
            ' Status Before ',
            ' Status After ',
            ' Document Type ',
            ' Document Number ',
            ' Technical Disclosure Number ',
            ' Payment Price ',
            ' Is Paid ',
            ' Where Maintained ',
            ' Reason ',
            ' Notes ',
        ];
    }

    public function map($maintenance):array {
        return [
            $maintenance->assets->items->itemName,
            $maintenance->assets->types->typeName,
            $maintenance->assets->codeNamaa,
            $maintenance->sendDate,
            $maintenance->receiveDate,
            $maintenance->statusBefore,
            $maintenance->statusAfter,
            $maintenance->documentType,
            $maintenance->documentNumber,
            $maintenance->technicalDisclosureNumber,
            $maintenance->paymentPrice,
            $maintenance->is_paid_name,
            $maintenance->where_maintained_name,
            $maintenance->reason,
            $maintenance->notes,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true],]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:O1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14)->getColor()->setRGB('ffffff');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00a8f3');
            },
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        if (checkdate($value)) {
            $cell->setValueExplicit($value, DataType::FORMAT_DATE_YYYYMMDD);

            return true;
        }

        

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

}
