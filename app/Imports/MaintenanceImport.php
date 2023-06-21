<?php

namespace App\Imports;

use App\Models\Maintenance;
use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Carbon;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;


class MaintenanceImport implements ToModel, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    public function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function get_asset_id($name){
        $assetId = Asset::where('codeNamaa', $name)->first();
        return $assetId->id;
    }

    public function model(array $row)
    {

        if(is_string($row[1])){
            $sendDate = $row[1];
        }

        if(!is_string($row[1])){
            $sendDate = $this->transformDate($row[1]);
        }

        if(is_string($row[2])){
            $receiveDate = $row[2];
        }

        if(!is_string($row[2])){
            $receiveDate = $this->transformDate($row[2]);
        }

        if(str_contains($row[9], 'Yes') || str_contains($row[9], 'No')){
            $isPaid = $row[9] == 'Yes' ? 1 : 0;
       }

       if(str_contains($row[9], '1') || str_contains($row[9], '0')){
            $isPaid = $row[9];
       }

       if(str_contains($row[10], 'External') || str_contains($row[10], 'Internal')){
        $whereMaintained = $row[10] == 'External' ? 1 : 0;
   }

   if(str_contains($row[10], '1') || str_contains($row[10], '0')){
        $whereMaintained = $row[10];
   }

        return new Maintenance([
            //
            'asset_id' => $this->get_asset_id($row[0]),
            'sendDate' => $sendDate,
            'receiveDate' => $receiveDate,
            'statusBefore' => $row[3],
            'statusAfter' => $row[4],
            'documentType' => $row[5],
            'documentNumber' => $row[6],
            'technicalDisclosureNumber' => $row[7],
            'paymentPrice' => $row[8],
            'isPaid' => $isPaid,
            'whereMaintained' => $whereMaintained,
            'reason' => $row[11],
            'notes' => $row[12],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [

            '0' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && is_numeric($value)){
                    $onFailure('Column[1] This Value MUST BE TEXT');
                    }
            },

            '1' => function($attribute, $value, $onFailure) {
                if($this->validateDate($value) && !is_string($value)){
                    $onFailure('Column[2] This Value MUST BE DATE');
                    }
            },

            '2' => function($attribute, $value, $onFailure) {
                if($this->validateDate($value) && !is_string($value)){
                    $onFailure('Column[3] This Value MUST BE DATE');
                    }
            },

            '3' => function($attribute, $value, $onFailure) {
                if(!is_string($value)){
                    $onFailure('Column[4] This Value MUST BE TEXT');
                    }
            },

            '4' => function($attribute, $value, $onFailure) {
                if(!is_string($value)){
                    $onFailure('Column[5] This Value MUST BE TEXT');
                    }
            },

            '5' => function($attribute, $value, $onFailure) {
                if(!is_string($value)){
                    $onFailure('Column[6] This Value MUST BE TEXT');
                    }

            },

            '6' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[7] This Value MUST BE INT');
                    }
                    if($value < 0){
                        $onFailure('Column[7] This Value MUST Have POSITIVE Numbers');
                    }
            },

            '7' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[8] This Value MUST BE INT');
                    }
                    if($value < 0){
                        $onFailure('Column[8] This Value MUST Have POSITIVE Numbers');
                    }
            },

            '8' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[9] This Value MUST BE INT');
                    }
                    if($value < 0){
                        $onFailure('Column[9] This Value MUST Have POSITIVE Numbers');
                    }
            },

            '9' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && !is_numeric($value)){
                    $onFailure('Column[10] This Value MUST BE TEXT OR Number');
                    }
                    if(strlen($value) != 3 && strlen($value) != 2 && strlen($value) != 1){
                        $onFailure('Column[10] This Value MUST BE "Yes" OR "No" OR "1" OR "0" ');
                    }
            },

            '10' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && !is_numeric($value)){
                    $onFailure('Column[11] This Value MUST BE TEXT OR Number');
                    }
                    if(strlen($value) != 8 && strlen($value) != 1){
                        $onFailure('Column[11] This Value MUST BE "External" OR "Internal" OR "1" OR "0" ');
                    }
            },

            '11' => function($attribute, $value, $onFailure) {
                if(!is_string($value)){
                    $onFailure('Column[12] This Value MUST BE TEXT');
                    }
            },

            '12' => function($attribute, $value, $onFailure) {
                if(!is_string($value)){
                    $onFailure('Column[13] This Value MUST BE TEXT');
                    }
            },

        ];
    }

}
