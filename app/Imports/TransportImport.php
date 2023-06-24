<?php

namespace App\Imports;

use App\Models\Transport;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Center;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Carbon;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;


class TransportImport implements ToModel, WithStartRow, WithValidation
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

    public function get_center_id($name){
        $centerId = Center::where('centerName', $name)->first();
        return $centerId->id;
    }

    public function get_position_id($name){
        $positionId = Position::where('positionName', $name)->first();
        return $positionId->id;
    }

    public function get_department_id($name){
        $departmentId = Department::where('departmentName', $name)->first();
        return $departmentId->id;
    }

    public function get_employee_id($name){
        $employeeId = Employee::where('fullName', $name)->first();
        return $employeeId->id;
    }

    public function model(array $row)
    {

        if(is_string($row[8])){
            $startDate = $row[8];
        }

        if(!is_string($row[8])){
            $startDate = $this->transformDate($row[11]);
        }

        if(str_contains($row[9], 'Yes') || str_contains($row[9], 'No')){
            $isHanded = $row[9] == 'Yes' ? 1 : 0;
       }

       if(str_contains($row[9], '1') || str_contains($row[9], '0')){
            $isHanded = $row[9];
       }

        return new Transport([
            //
            'asset_id' => $this->get_asset_id($row[0]),
            'center_id' => $this->get_center_id($row[1]),
            'department_id' => $this->get_department_id($row[2]),
            'position_id' => $row[3] == null ? null : $this->get_position_id($row[3]),
            'employee_id' => $row[4] == null ? null : $this->get_employee_id($row[4]),
            'employee_prev_id' => $row[5] == null ? null : $this->get_employee_id($row[5]),
            'documentType' => $row[6],
            'documentNumber' => $row[7],
            'transportDate' => $startDate,
            'isHanded' => $isHanded,
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
                //         $onFailure('Column[2] This Value MUST Have POSITIVE Numbers');
                // }
            },

            '2' => function($attribute, $value, $onFailure) {
                if(!is_string($value) || is_numeric($value)){
                $onFailure('Column[3] This Value MUST BE TEXT');
                }
            },

            '3' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && $value !== null){
                $onFailure('Column[4] This Value MUST BE TEXT');
                }
            },

            '4' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && $value !== null){
                    $onFailure('Column[5] This Value MUST BE TEXT');
                }
                // if($value < 0){
                //         $onFailure('Column[2] This Value MUST Have POSITIVE Numbers');
                // 
            },

            '5' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && $value !== null){
                    $onFailure('Column[6] This Value MUST BE TEXT');
                }
                // if($value < 0){
                //         $onFailure('Column[2] This Value MUST Have POSITIVE Numbers');
                // 
            },

            '6' => function($attribute, $value, $onFailure) {
                    if(!is_string($value)){
                        $onFailure('Column[7] This Value MUST BE TEXT');
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
                if($this->validateDate($value) && !is_string($value)){
                    $onFailure('Column[9] This Value MUST BE DATE');
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

        ];
    }

}
