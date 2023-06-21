<?php

namespace App\Exports;

use App\Models\Transport;
use Maatwebsite\Excel\Concerns\FromCollection;
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
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\withMapping;

class TransportExport extends DefaultValueBinder implements FromCollection,WithHeadings, withStrictNullComparison, shouldAutoSize, WithStyles, WithEvents, WithCustomValueBinder, withMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transport::all();
    }

    public function headings(): array
    {
        return [
            ' Asset Name ',
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
            $transport->assets->codeNamaa,
            $transport->centers->centerName,
            $transport->departments->departmentName,
            $transport->positions->positionName,
            $transport->employees->fullName,
            $transport->prevs->fullName,
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
                $cellRange = 'A1:J1'; // All headers
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
