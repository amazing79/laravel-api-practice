<?php

namespace App\Http\Controllers\Api\v1;

use App\Filters\v1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//Resources
//Filters

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\StoreCustomerRequest  $request
     * @return CustomerResource
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\UpdateCustomerRequest  $request
     * @param Customer $customer
     * @return Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): Response
    {
        try {
            $customer->update($request->all());
            return  new Response('Excelente fiera!');
        } catch (\Exception $e) {
            return new Response('Que hiciste cabeza?', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
