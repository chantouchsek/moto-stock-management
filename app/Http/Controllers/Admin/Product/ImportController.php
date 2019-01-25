<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Requests\Admin\Product\ImportRequest;
use App\Imports\ProductsImport;
use App\Traits\Authorizable;
use App\Http\Controllers\Controller;

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
        $collection = (new ProductsImport())->queue($request->input('file'));
        return $this->respond([
            'data' => $collection,
            'message' => 'Product imported'
        ]);
    }
}
