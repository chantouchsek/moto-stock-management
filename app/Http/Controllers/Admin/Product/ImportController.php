<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Requests\Admin\Product\ImportRequest;
use App\Imports\ProductsImport;
use App\Traits\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    use Authorizable;

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(ImportRequest $request)
    {
        $file = $request->file('file');
        (new ProductsImport)->import($file);
        return $this->respondCreated('Products imported success fully');
    }

    public function downloadSample()
    {
        try {
            $file = Storage::disk('public')->get('excel/product-upload-sample.xlsx');
            $headers = [
                'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];
            return $this->respondWithFile($file, 'product-upload-sample.xlsx', $headers);
        } catch (FileNotFoundException $e) {
            return $this->respondNotFound('File not found');
        }
    }
}
