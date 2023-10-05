<?php

namespace App\Filters\v1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;
class CustomerFilter extends ApiFilter
{
    protected $allowedParams = [
        'name' => ['eq', 'like'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq', 'like'],
        'city' => ['eq', 'like'],
        'state' => ['eq', 'like'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
    ];
}
