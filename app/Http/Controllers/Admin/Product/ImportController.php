<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Requests\Admin\Product\ImportRequest;
use App\Imports\ProductsImport;
use App\Traits\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadSample(Request $request)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/excel/product-upload-sampe.xlsx";
        $headers = [
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        return Response::download($file, 'product-upload-sampe.xlsx', $headers);
    }
}
