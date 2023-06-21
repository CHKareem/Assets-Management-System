<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;


class ItemImport implements ToModel, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        return new Item([
            //
            'id' => $row[0],
            'itemName' => $row[1],
            'arabicItemName' => $row[2],
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
                if(!is_string($value) && is_numeric($value)){
                $onFailure('Column[2] This Value MUST BE TEXT');
                }
            },

            '2' => function($attribute, $value, $onFailure) {
                if(!is_string($value) && is_numeric($value)){
                $onFailure('Column[3] This Value MUST BE TEXT');
                }
            },

        ];
    }

}
