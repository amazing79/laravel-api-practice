<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
//Resources
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
//Filters
use App\Filters\v1\CustomerFilter;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CustomerCollection
     */
    public function index(Request $request): CustomerCollection
    {
        $filter = new CustomerFilter();
        $queryItems = $filter->transform($request);
        $includeInvoices = $request->query('includeInvoices', false) ?? false;
        //Notar que Customer::where([]) toma como que no incluye filtros y es equivalente a Customer::paginate();
        $customers = Customer::where($queryItems);
        if($includeInvoices){
            $customers = $customers->with('invoices');
        }
        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer): CustomerResource
    {
        /*
        $response = new CustomerResource($customer);
        return $response->toArray();
        */
        $includeInvoices = request()->query('includeInvoices') ?? false;
        if ($includeInvoices) {
            $customer = $customer->loadMissing('invoices');
        }
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
