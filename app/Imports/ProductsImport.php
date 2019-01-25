<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToCollection, WithChunkReading, WithBatchInserts, ShouldQueue, WithValidation
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Product::create([
                'make_id' => $row[0],
                'model_id' => $row[1],
                'category_id' => $row[2],
                'color_id' => $row[3],
                'name' => $row[4],
                'description' => $row[5],
                'price' => $row[6],
                'cost' => $row[7],
                'year' => $row[8],
                'import_from' => $row[9],
                'date_import' => $row[10],
                'engine_number' => $row[11],
                'plate_number' => $row[12],
                'frame_number' => $row[13],
                'status' => $row[14],
                'code' => $row[15],
                'supplier_id' => $row[15]
            ]);
        }
    }

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
     * @return array
     */
    public function rules(): array
    {
        return [
            '5' => 'required|string|min:2',
            '6' => 'required',
            '7' => 'required',
            '16' => [
                'required',
                Rule::exists('suppliers', 'id')
            ],
            '3' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            '1' => [
                'required',
                Rule::exists('makes', 'id')
            ],
            '2' => [
                'required',
                Rule::exists('models', 'id')
            ],
            '4' => [
                'required',
                Rule::exists('colors', 'id')
            ],
            '10' => 'required|date',
            '11' => 'required',
            '13' => 'required'
        ];
    }
}
