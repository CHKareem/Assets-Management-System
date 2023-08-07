<?php

namespace App\Exports;

use App\Models\Transport;
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

class CustomTransportExport extends DefaultValueBinder implements FromQuery,WithHeadings, withStrictNullComparison, shouldAutoSize, WithStyles, WithEvents, WithCustomValueBinder, withMapping
{

    use Exportable;

    public function __construct($transportCode, $transportType, $firstDate, $secondDate){
        $this->transportCode = $transportCode;
        $this->transportType = $transportType;
        $this->firstDate = $firstDate;
        $this->secondDate = $secondDate;
    }

    public function query()
    {
            return Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')
            ->where('asset_id', $this->transportCode)->orWhere('employee_id', $this->transportCode)->where('documentType', $this->transportType)->whereBetween('transportDate',[$this->firstDate, $this->secondDate]);
        
    }

    public function headings(): array
    {
        return [
            ' Item Name ',
            ' Type Name ',
            ' Description ',
            ' Code Namaa ',
            ' Center Name ',
            ' Department Name ',
            ' Position Name ',
            ' Employee Name ',
            ' Previous Employee Name ',
            ' Document Type ',
            ' Document Number ',
            ' Transport Date ',
            ' Is Handed ',
        ];
    }

    public function map($transport):array {
        return [
            $transport->assets->items->itemName,
            $transport->assets->types->typeName,
            $transport->assets->description,
            $transport->assets->codeNamaa,
            $transport->centers->centerName,
            $transport->departments->departmentName,
            $transport->position_id == null ? '---' : $transport->positions->positionName ,
            $transport->employee_id== null ? '---' : $transport->employees->fullName,
            $transport->employee_prev_id== null ? '---' : $transport->prevs->fullName,
            $transport->documentType,
            $transport->documentNumber,
            $transport->transportDate,
            $transport->is_handed_name,
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
                $cellRange = 'A1:M1'; // All headers
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
