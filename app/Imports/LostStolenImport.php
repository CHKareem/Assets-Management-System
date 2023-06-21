<?php

namespace App\Imports;

use App\Models\LostStolen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Carbon;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;


class LostStolenImport implements ToModel, WithStartRow, WithValidation
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
        $assetId = DB::table('assets')->where('codeNamaa', $name)->first();
        return $assetId->id;
    }

    public function model(array $row)
    {

        if(is_string($row[3])){
            $lostDate = $row[3];
        }

        if(!is_string($row[3])){
            $lostDate = $this->transformDate($row[3]);
        }

        if(str_contains($row[4], 'Yes') || str_contains($row[4], 'N')){
            $isStolen = $row[4] == 'Yes' ? 1 : 0;
       }

       if(str_contains($row[4], '1') || str_contains($row[4], '0')){
            $isStolen = $row[4];
       }

        return new LostStolen([
            //
            'asset_id' => $this->get_asset_id($row[0]),
            'asset_alter_id' => $this->get_asset_id($row[1]),
            'documentNumber' => $row[2],
            'lostDate' => $lostDate,
            'isStolen' => $isStolen,
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
                // if($value < 0){
                //     $onFailure('Column[1] This Value MUST Have POSITIVE Numbers');
                // }
            },

            '1' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && is_numeric($value)){
                $onFailure('Column[2] This Value MUST BE TEXT');
                }
                // if($value < 0){
                //     $onFailure('Column[1] This Value MUST Have POSITIVE Numbers');
                // }
            },

            '2' => function($attribute, $value, $onFailure) {
                if(!is_int($value) && !is_string($value)){
                    $onFailure('Column[3] This Value MUST BE INT');
                    }
                    if($value < 0){
                        $onFailure('Column[3] This Value MUST Have POSITIVE Numbers');
                    }
            },

            '3' => function($attribute, $value, $onFailure) {
                if($this->validateDate($value) && !is_string($value)){
                    $onFailure('Column[4] This Value MUST BE DATE');
                    }
            },

            '4' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && !is_numeric($value)){
                    $onFailure('Column[5] This Value MUST BE TEXT OR Number');
                    }
                    if(strlen($value) != 3 && strlen($value) != 2 && strlen($value) != 1){
                        $onFailure('Column[5] This Value MUST BE "Yes" OR "No" OR "1" OR "0" ');
                    }
            },

        ];
    }

}
