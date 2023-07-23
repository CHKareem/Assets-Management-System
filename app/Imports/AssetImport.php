<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Item;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Carbon;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;


class AssetImport implements ToModel, WithStartRow, WithValidation
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

    public function get_item_id($name){
        $itemId = DB::table('items')->where('itemName', $name)->first();
        return $itemId->id;
    }

    public function get_type_id($name){
        $typeId = Type::where('typeName', $name)->first();
        return $typeId->id;
    }

    public function model(array $row)
    {

        if(is_string($row[9])){
            $startDate = $row[9];
        }

        if(!is_string($row[9])){
            $startDate = $this->transformDate($row[9]);
        }

        if(str_contains($row[15], 'In Service') || str_contains($row[15], 'Not In Service')){
            $inService = $row[15] == 'In Service' ? 1 : 0;
       }

       if(str_contains($row[15], '1') || str_contains($row[15], '0')){
            $inService = $row[15];
       }

        return new Asset([
            //
            'item_id' => $this->get_item_id($row[0]),
            'type_id' => $this->get_type_id($row[1]),
            'codeNamaa' => $row[2],
            'description' => $row[3],
            'status' => $row[4],
            'quantity' => $row[5],
            'realPrice' => $row[6],
            'expectedPrice' => $row[7],
            'serialNumber' => $row[8],
            'aquisitionDate' => $startDate,
            'aquisitionType' => $row[10],
            'fundedBy' => $row[11],
            'partnerName' => $row[12],
            'documentNumber' => $row[13],
            'notes' => $row[14],
            'inService' => $inService,
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
                if(!is_int($value) && !is_string($value)){
                $onFailure('Column[1] This Value MUST BE INT OR TEXT');
                }
                if($value < 0){
                    $onFailure('Column[1] This Value MUST Have POSITIVE Numbers');
                }
            },

            '1' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[2] This Value MUST BE INT OR TEXT');
                }
                if($value < 0){
                        $onFailure('Column[2] This Value MUST Have POSITIVE Numbers');
                }
            },

            '2' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && is_numeric($value)){
                $onFailure('Column[3] This Value MUST BE TEXT');
                }
            },

            '3' => function($attribute, $value, $onFailure) {
                if(!is_string($value) || is_numeric($value)){
                $onFailure('Column[4] This Value MUST BE TEXT');
                }
            },

            '4' => function($attribute, $value, $onFailure) {
                if(!is_string($value) || is_numeric($value)){
                $onFailure('Column[5] This Value MUST BE TEXT');
                }
            },

            '5' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[6] This Value MUST BE INT');
                    }
                    if($value < 0){
                        $onFailure('Column[6] This Value MUST Have POSITIVE Numbers');
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
                if(!is_string($value)){
                $onFailure('Column[9] This Value MUST BE TEXT');
                }
            },

            '9' => function($attribute, $value, $onFailure) {
                if($this->validateDate($value) && !is_string($value)){
                    $onFailure('Column[10] This Value MUST BE DATE');
                    }
            },

            '10' => function($attribute, $value, $onFailure) {
                if(!is_string($value)){
                    $onFailure('Column[11] This Value MUST BE TEXT');
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

            '13' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[14] This Value MUST BE INT');
                    }
                    if($value < 0){
                        $onFailure('Column[14] This Value MUST Have POSITIVE Numbers');
                    }
            },

            '14' => function($attribute, $value, $onFailure) {
                if(!is_string($value) || is_numeric($value)){
                $onFailure('Column[15] This Value MUST BE TEXT');
                }
            },

            '15' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && !is_numeric($value)){
                    $onFailure('Column[16] This Value MUST BE TEXT OR Number');
                    }
                    if(strlen($value) != 10 && strlen($value) != 14 && strlen($value) != 1){
                        $onFailure('Column[16] This Value MUST BE "In Service" OR "Not In Service" OR "1" OR "0" ');
                    }
            },

        ];
    }

}
