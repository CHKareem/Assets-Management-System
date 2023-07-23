<?php

namespace App\Exports;

use App\Models\Asset;
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

class CustomGPExport extends DefaultValueBinder implements FromQuery,WithHeadings, withStrictNullComparison, shouldAutoSize, WithStyles, WithEvents, WithCustomValueBinder, withMapping
{

    use Exportable;

    public function __construct($date1,$date2){
        $this->date1 = $date1;
        $this->date2 = $date2;
    }

    public function query()
    {
            return Asset::with('items', 'types')->whereBetween('created_at',[$this->date1, $this->date2]);
        
    }

    public function headings(): array
    {
        return [
            ' Item Name ',
            ' Type Name ',
            ' Code Namaa ',
            ' Status ',
            ' Quantity ',
            ' Real Price ',
            ' Total Cost ',
            ' Serial Number ',
            ' Aquisition Date ',
            ' Aquisition Type ',
            ' Funded By ',
            ' Document Number ',
            ' Notes ',
            ' In Service ',
            ' Description ',
        ];
    }

    public function map($asset):array {
        return [
            $asset->items->itemName,
            $asset->types->typeName,
            $asset->codeNamaa,
            $asset->status,
            $asset->quantity,
            $asset->realPrice == 0 ? $asset->partnerName : $asset->realPrice,
            $asset->realPrice * $asset->quantity,
            $asset->serialNumber,
            $asset->aquisitionDate,
            $asset->aquisitionType,
            $asset->fundedBy,
            $asset->documentNumber,
            $asset->notes,
            $asset->in_service_name,
            $asset->description,
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
