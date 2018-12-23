<?php

namespace App\Http\Controllers\Admin\Expense;

use App\Http\Requests\Admin\Expense\DeleteRequest;
use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Transformers\ExpenseTransformer;
use App\Http\Requests\Admin\Expense\UploadRequest;
use Spatie\MediaLibrary\Models\Media;

class UploadAttachmentController extends Controller
{
    /**
     * @var ExpenseTransformer The transformer used to transform the model.
     */
    protected $transformer;

    /**
     * ExpenseController constructor.
     * @param ExpenseTransformer $transformer The transformer used to transform the model
     */
    public function __construct(ExpenseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param UploadRequest $request
     * @param Expense $expense
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UploadRequest $request, Expense $expense)
    {
        $input = $request->all();
        if ($request->hasFile('files')) {
            $expense->addMultipleMediaFromRequest(['files'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('attachments');
            });
        }
        $expense->update($input);
        return $this->respond(['data' => $this->transformer->transform($expense), 'message' => 'Files uploaded.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense $expense
     * @param DeleteRequest $request
     * @param Media $upload
     * @return \Illuminate\Http\JsonResponse
     * @throws \Spatie\MediaLibrary\Exceptions\MediaCannotBeDeleted
     */
    public function destroy(Expense $expense, DeleteRequest $request, Media $upload)
    {
        if ($expense->hasMedia('attachments')) {
            $expense->deleteMedia($upload);
        }
        return $this->respond([
            'data' => $this->transformer->transform($expense),
            'message' => 'Item deleted.'
        ]);
    }
}
