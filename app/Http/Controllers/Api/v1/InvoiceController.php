<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\v1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

//Resources
//Filters
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return InvoiceCollection
     */
    public function index(Request $request): InvoiceCollection
    {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);
        $invoices = Invoice::where($queryItems)->paginate();
        return new InvoiceCollection($invoices->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\StoreInvoiceRequest  $request
     * @return Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        $bulk = collect($request->all())
                ->map(function ($arr, $key) {
                    return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
                });

        Invoice::insert($bulk->toArray());
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return InvoiceResource
     */
    public function show(Invoice $invoice): InvoiceResource
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
