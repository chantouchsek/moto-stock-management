<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Webpatser\Uuid\Uuid;

class ProductsImport implements ToModel, WithChunkReading, WithBatchInserts, ShouldQueue, WithValidation, WithHeadingRow
{
    use Importable;

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }


    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        return new Product([
            'make_id' => $row['make'],
            'model_id' => $row['model'],
            'category_id' => $row['category'],
            'color_id' => $row['color'],
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'cost' => $row['cost'],
            'year' => $row['year'],
            'import_from' => $row['import_from'],
            'date_import' => $row['date_import'],
            'engine_number' => $row['engine_number'],
            'plate_number' => $row['plate_number'],
            'frame_number' => $row['frame_number'],
            'status' => $row['status'],
            'code' => $row['code'],
            'supplier_id' => $row['supplier'],
            'uuid' => (string)Uuid::generate(4)
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'price' => 'required',
            'cost' => 'required',
            'supplier' => [
                'required',
                Rule::exists('suppliers', 'id')
            ],
            'category' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            'make' => [
                'required',
                Rule::exists('makes', 'id')
            ],
            'model' => [
                'required',
                Rule::exists('models', 'id')
            ],
            'color' => [
                'required',
                Rule::exists('colors', 'id')
            ],
            'date_import' => 'required|date',
            'engine_number' => 'required',
            'frame_number' => 'required'
        ];
    }
}
